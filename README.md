
<b>🍽️ Comanda y Gestión de Reservas – Abacería La Juana</b>

⭐ Sistema integrado Web + Backend + App Móvil

Es una de mis primeras Apps desarrolladas con Ionic y Spring

<b>
📖 Descripción del Proyecto
</b>

Este proyecto implementa un sistema completo de gestión de reservas y comandas para la Abacería La Juana.

Los clientes reservan desde la web (WordPress).
El personal gestiona reservas desde la app móvil (Ionic).
El backend (Spring Boot) almacena, consulta, actualiza y genera notificaciones por correo.

<b>
🏛️ Arquitectura General
</b>

El sistema está dividido en tres capas:

Frontend Web (WordPress)
        ↓
 Backend API (Spring Boot)
        ↓
 App Móvil (Ionic / Angular)

<b>
🌐 Frontend Web – WordPress Plugin
</b>

Plugin personalizado que incluye:

✔ Formulario de reserva
✔ Validación y sanitización de datos
✔ Envío seguro al backend
✔ Endpoints REST propios

Datos recibidos en la reserva:

Nombre

Teléfono

Correo electrónico

Fecha de la reserva

Número de comensales

Endpoints expuestos:

GET /reservas
GET /reservas?fecha=
PUT /reservas/{id}/confirmar

<b>
⚙️ Backend – API REST con Spring Boot
 </b>

El backend gestiona toda la lógica del sistema:

CRUD de reservas

Validación del modelo

Notificaciones por correo

Integración con la app móvil

Endpoints principales:

GET /api/reservas
POST /api/reservas
PUT /api/reservas/{id}


Modelo Reserva:

Campo	Tipo
id	Long
nombre	String
telefono	String
correo	String
fecha	LocalDate
numComensales	int
estado	Enum
<b>
📱 App Móvil – Ionic / Angular
</b>

Aplicación diseñada para el personal del restaurante.

Funcionalidades:

Ver reservas por día

Aceptar/rechazar reservas

Ver estado de confirmación

Gestionar comandas por reserva

Comunicación directa con la API REST

<b>
🔄 Flujo Completo del Sistema
</b>
Cliente → WordPress → Backend API → BD → App Móvil → Cliente


El cliente hace la reserva en la web.

WordPress envía los datos al backend.

El backend la guarda en MySQL/PostgreSQL/MariaDB.

La app móvil consulta la API.

El personal gestiona la reserva.

El cliente recibe el correo de confirmación.
<b>
🛠️ Tecnologías Utilizadas
</b>

Capa	Tecnología
Web	WordPress (PHP)
Backend	Spring Boot (Java), JPA/Hibernate
Móvil	Ionic / Angular
BD	MySQL / PostgreSQL / MariaDB
API	REST / JSON

<b>
🎯 Objetivo del Proyecto
</b>

Crear un sistema moderno que automatice la gestión de reservas y mejore la comunicación entre cliente y personal, integrando todas las capas en un único flujo optimizado.

<b>
🚀 Próximas Mejoras
</b>

🔐 Autenticación en la app móvil

🔔 Notificaciones push

🖥️ Panel administrativo web

📊 Estadísticas internas de ocupación
