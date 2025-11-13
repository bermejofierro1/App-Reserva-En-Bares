<?php
/**
 * Plugin Name: Custom Form Plugin
 * Description: Un plugin para crear un formulario de reservas y guardar los datos en la base de datos.
 * Version: 1.0
 * Author: Miguel Bermejo
 */

// Evita el acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Encolar el CSS personalizado
function custom_form_plugin_styles() {
    wp_enqueue_style('custom-form-styles', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'custom_form_plugin_styles');


// Agregar un shortcode para el formulario
function custom_form_shortcode() {
    ob_start();
    ?>
<div class="form-container">
    <form action="" method="POST">
        <label for="user_name">Nombre:</label>
        <input type="text" name="user_name" id="user_name" required>

        <label for="user_phone">Teléfono:</label>
        <input type="text" name="user_phone" id="user_phone" required>

        <label for="user_email">Correo electrónico:</label>
        <input type="email" name="user_email" id="user_email" required>

        <label for="user_date">Fecha de la reserva:</label>
        <input type="datetime-local" name="user_date" id="user_date" required>

        <label for="user_persons">Número de personas:</label>
        <input type="number" name="user_persons" id="user_persons" required>

        <?php wp_nonce_field('custom_form_nonce_action', 'custom_form_nonce'); ?>

        <input type="submit" name="submit_custom_form" value="Reservar">
    </form>
</div>
    <?php
    // Procesar el formulario si se ha enviado
    if (isset($_POST['submit_custom_form'])) {
        custom_form_process();
    }

    return ob_get_clean();
}
add_shortcode('custom_form', 'custom_form_shortcode');


// Función para procesar el formulario y guardar en la base de datos
function custom_form_process() {
    global $wpdb;

    // Verificar nonce
    if (!isset($_POST['custom_form_nonce']) || !wp_verify_nonce($_POST['custom_form_nonce'], 'custom_form_nonce_action')) {
        echo '<div class="form-message error">Error: No autorizado.</div>';
        return;
    }

    // Sanitize y validar los datos
    $name = sanitize_text_field($_POST['user_name']);
    $phone = sanitize_text_field($_POST['user_phone']);
    $email = sanitize_email($_POST['user_email']);
    $date = sanitize_text_field($_POST['user_date']);
    $persons = intval($_POST['user_persons']);

    // Verificar si los datos son válidos
    if (empty($name) || empty($phone) || empty($email) || empty($date) || empty($persons)) {
        echo '<div class="form-message error">Por favor, rellene todos los campos.</div>';
        return;
    }

    // Valor predeterminado para el campo 'confirmada'
    $confirmada = 'pendiente';  // O cualquier valor por defecto que prefieras

    // Insertar los datos en la base de datos
    $table_name = $wpdb->prefix . 'reservas_restaurante'; // Prefijo de la tabla
    $data = array(
        'nombre'    => $name,
        'telefono'  => $phone,
        'email'     => $email,
        'fecha'     => $date,
        'personas'  => $persons,
        'confirmada' => $confirmada,  // Añadir el valor de 'confirmada'
    );
    $format = array('%s', '%s', '%s', '%s', '%d', '%s'); // Formatos de los datos

    $wpdb->insert($table_name, $data, $format);

    if ($wpdb->last_error) {
        echo '<div class="form-message error">Error al guardar la reserva: ' . esc_html($wpdb->last_error) . '</div>';
    } else {
        echo '<div class="form-message success">¡Reserva realizada correctamente!</div>';
    }
}


function get_reservas_restaurante() {
    global $wpdb;

    // Consultar la base de datos para obtener las reservas, incluyendo el campo confirmada
    $table_name = $wpdb->prefix . 'reservas_restaurante'; // Prefijo de la tabla
    $results = $wpdb->get_results("SELECT id, nombre, telefono, email, fecha, personas, confirmada FROM $table_name ORDER BY fecha ASC");

    // Verifica que los resultados incluyen 'confirmada'
    error_log(print_r($results, true));
 

    // Si no hay resultados, devolver un mensaje vacío
    if (empty($results)) {
        return new WP_Error('no_reservas', 'No hay reservas en la base de datos', array('status' => 404));
    }

    // Devolver los resultados como una respuesta JSON
    return rest_ensure_response($results);
}



// Registrar el endpoint en la API REST
function register_reservas_endpoint() {
    register_rest_route('api/v1', '/reservas', array(
        'methods' => 'GET',
        'callback' => 'get_reservas_restaurante',
        'permission_callback' => '__return_true', // Hacer público el endpoint (puedes modificar la seguridad)
    ));
}
add_action('rest_api_init', 'register_reservas_endpoint');



// Función que actualiza el estado de la reserva en la base de datos
function actualizar_reserva(WP_REST_Request $request) {
    global $wpdb;
    $tabla = $wpdb->prefix . 'reservas_restaurante'; 

    $id = $request->get_param('id');
    $confirmada = $request->get_param('confirmada');

    // Obtener los datos de la reserva antes de actualizar
    $reserva = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tabla WHERE id = %d", $id));

    if (!$reserva) {
        return new WP_REST_Response(['error' => 'Reserva no encontrada'], 404);
    }

    // Actualizar la reserva en la base de datos
    $wpdb->update($tabla, ['confirmada' => $confirmada], ['id' => $id]);

    // Enviar correo de confirmación o rechazo
    $to = $reserva->email;
    $subject = "Estado de tu reserva en La Juana";
    
    if ($confirmada === 'aceptada') {
        $message = "Hola {$reserva->nombre},\n\nTu reserva para el {$reserva->fecha} ha sido *ACEPTADA*.\n\n¡Te esperamos!";
    } elseif ($confirmada === 'rechazada') {
        $message = "Hola {$reserva->nombre},\n\nLamentamos informarte que tu reserva para el {$reserva->fecha} ha sido *RECHAZADA*.\n\nSi necesitas más información, contáctanos.";
    }

    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    wp_mail($to, $subject, $message, $headers);

    return new WP_REST_Response(['message' => 'Reserva actualizada y correo enviado'], 200);
}
add_action('rest_api_init', function() {
    register_rest_route('reservas/v1', '/actualizar-reserva/', array(
        'methods' => 'PUT',
        'callback' => 'actualizar_reserva',
        'permission_callback' => '__return_true', // Ajusta según las necesidades de seguridad
    ));
});

/*RESERVAS FILTRADAS POR PENDIENTES*/
add_action('rest_api_init', function () {
    register_rest_route('reservas/v1', '/pendientes', array(
        'methods' => 'GET',
        'callback' => 'obtener_reservas_pendientes',
        'permission_callback' => '__return_true',
    ));
});

function obtener_reservas_pendientes() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'reservas_restaurante';

    // Obtener solo las reservas con confirmada = 'pendiente'
    $reservas = $wpdb->get_results("SELECT * FROM $tabla WHERE confirmada = 'pendiente'", ARRAY_A);

    if (!$reservas) {
        return new WP_REST_Response(['message' => 'No hay reservas pendientes'], 200);
    }

    return new WP_REST_Response($reservas, 200);
}


function get_reservas_restaurante_por_fecha(WP_REST_Request $request){

    global $wpdb;
    $tabla=$wpdb-> prefix . 'reservas_restaurante';

    $fecha=$request -> get_param('fecha');

    if(!$fecha){

        return new WP_REST_Response(['message' => 'Se requiere el parámetro fecha '],400);
    }
    $reservas=$wpdb-> get_results(

        $wpdb->prepare("SELECT * FROM $tabla WHERE DATE(fecha) = %s ORDER BY fecha ASC",$fecha),ARRAY_A
        );

    if(!$reservas){

        return new WP_REST_Response(['message' => 'No hay reservas para la fecha indicada']);
    }

    return new WP_REST_Response($reservas,200);

}

//registro el endpoint en la api
function register_reservas_por_fecha_endpoint(){
    register_rest_route('api/v1','/reservas-fecha',array(

        'methods' => 'GET',
        'callback' => 'get_reservas_restaurante_por_fecha',
        'permission_callback' => '__return_true'

    ));
}
add_action('rest_api_init','register_reservas_por_fecha_endpoint');

