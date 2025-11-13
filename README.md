🍽 Comanda y Gestión de Reservas – Abacería La Juana

Sistema completo para la gestión de reservas y comandas de un restaurante, con integración entre web (WordPress), backend (Spring Boot) y app móvil (Ionic/Angular).
Este proyecto unifica la experiencia del cliente y del personal del local en un único flujo digital moderno.

📖 Descripción del Proyecto

Es una de mis primeras Apps desarrolladas con Ionic y Spring.

Este sistema permite:

Que los clientes realicen reservas desde la página web del restaurante.

Que el personal gestione reservas y comandas desde una aplicación móvil.

Que el backend administre la información, procese reservas y envíe notificaciones por correo.

El objetivo es automatizar y simplificar la operativa diaria de un restaurante real: Abacería La Juana.

🏛 Arquitectura General

El proyecto está dividido en tres capas principales:

Frontend Web (WordPress)  →  Backend (Spring Boot API)  →  App Móvil (Ionic)

🔹 1. Frontend Web (WordPress Plugin)

Se desarrolla un plugin propio para gestionar el formulario de reservas.

Funcionalidades:

Formulario de reserva con los campos:

Nombre

Teléfono

Correo electrónico

Fecha

Número de comensales

Validación y sanitización de datos.

Envío seguro al backend mediante llamadas REST.

Endpoints REST incluidos en el plugin:

GET /reservas → Obtener todas las reservas desde WordPress

GET /reservas?fecha= → Filtrar por fecha

PUT /reservas/{id}/confirmar → Actualizar estado de confirmación

🔹 2. Backend (Spring Boot / Java)

La API REST centraliza toda la lógica del sistema.

Endpoints principales:

GET /api/reservas → Listar reservas

POST /api/reservas → Crear reserva

PUT /api/reservas/{id} → Actualizar datos o estado

Modelo Reserva:

Campo	Tipo
id	Long
nombre	String
telefono	String
correo	String
fecha	LocalDate
numComensales	int
estado	Enum

Características adicionales:

Repositorio JPA para operaciones CRUD.

Envío de correos automáticos al confirmar/rechazar reservas.

Preparado para integrarse con la app móvil.

🔹 3. App Móvil (Ionic / Angular)

Aplicación usada por el personal del restaurante.

Funcionalidades:

Visualización de reservas por fecha.

Aceptar o rechazar reservas.

Estado de confirmación en tiempo real.

Gestión de comandas asociadas a una reserva.

Interacción directa con la API REST.

🔄 Flujo Completo del Sistema
Cliente → Web WordPress → Backend API → Base de Datos → App Móvil → Cliente


1️⃣ El cliente envía una reserva desde la web.
2️⃣ WordPress valida los datos y los envía al backend.
3️⃣ El backend guarda la reserva en MySQL/PostgreSQL/MariaDB.
4️⃣ La app Ionic obtiene la reserva mediante la API.
5️⃣ El personal acepta/rechaza la solicitud.
6️⃣ El cliente recibe un correo automático de confirmación.

🛠 Tecnologías Utilizadas
Capa	Tecnología
Web	WordPress (PHP)
Backend	Spring Boot (Java), JPA/Hibernate
App Móvil	Ionic / Angular
Base de Datos	MySQL / PostgreSQL / MariaDB
Comunicación	API REST JSON
🎯 Objetivo del Proyecto

Crear un ecosistema digital unificado para un restaurante real, que permita:

Automatizar reservas.

Facilitar la gestión del personal.

Integrar web + backend + móvil sin fricciones.

Mejorar la experiencia del cliente.

🚀 Próximas Mejoras

🔐 Sistema de autenticación para personal en la app móvil.

🔔 Notificaciones push para nuevas reservas.

🖥️ Panel web administrativo completo.

📊 Estadísticas internas de ocupación y rendimiento.
