🍽 Comanda y Gestión de Reservas para Bares

📖 Descripción
Unas de mis primeras Aplicaciones desarrollando Front con Ionic y Back con Spring juntos

Este proyecto permite la gestión completa de reservas de un restaurante mediante un flujo web y móvil.

Los clientes pueden realizar reservas desde la web del restaurante.

El personal gestiona las reservas desde una app móvil desarrollada con Ionic.

El backend se encarga de almacenar, consultar y actualizar reservas, además de enviar notificaciones de confirmación por correo.

🏛 Arquitectura del Proyecto
🌐 Frontend Web (WordPress Plugin)

Plugin Custom Form Plugin para reservas.

Permite al cliente introducir:

Nombre

Teléfono

Correo electrónico

Fecha

Número de comensales

Los datos se validan y sanitizan antes de enviarlos al backend.

Incluye endpoints REST para:

Obtener reservas

Filtrar por fecha

Actualizar estado de confirmación

⚙️ Backend (Spring Boot / Java)

API REST desarrollada en Spring Boot (JuanaApplication).

Endpoints principales:

GET /api/reservas → Obtener todas las reservas

POST /api/reservas → Crear una nueva reserva

Modelo Reserva con campos:

id, nombre, telefono, correo, fecha, numComensales

Repositorio ReservaRepository usando Spring Data JPA para operaciones CRUD.

Permite integración con la app móvil y envío automático de correos al actualizar el estado de la reserva.

📱 App Móvil (Ionic / Angular)

Consume la API REST para mostrar reservas activas y finalizadas.

Funcionalidades:

Ver reservas por día

Aceptar o rechazar reservas

Mostrar estado de confirmación

Gestión de comandas asociadas a cada reserva

🔄 Flujo de Trabajo

El cliente realiza una reserva desde la página web.

El plugin de WordPress valida los datos y los envía al backend.

El backend guarda la reserva en la base de datos (MySQL / MariaDB / PostgreSQL).

La app Ionic consulta la API y muestra las reservas al personal.

El personal puede aceptar o rechazar reservas, enviando notificaciones automáticas por correo al cliente.

🛠 Tecnologías Usadas
Capa	Tecnología
Web	WordPress (PHP)
Backend	Spring Boot (Java) con JPA/Hibernate
Móvil	Ionic / Angular
Base de Datos	MySQL / PostgreSQL / MariaDB
🎯 Objetivo

Crear un sistema integrado de reservas que unifique la experiencia web y móvil, automatizando el flujo de gestión de reservas y permitiendo al personal del restaurante controlar fácilmente las solicitudes de los clientes.

🚀 Próximos pasos

Añadir autenticación para el personal del restaurante en la app móvil.

Integración de notificaciones push para reservas nuevas.

Panel web administrativo para visualizar y filtrar reservas.
