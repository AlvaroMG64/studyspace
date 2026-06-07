# 📚 StudySpace - Sistema de Gestión de Reservas de Estudio

StudySpace es una aplicación web desarrollada como Proyecto Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW). Su objetivo es digitalizar y gestionar el sistema de reservas de espacios de estudio dentro de bibliotecas, permitiendo a los usuarios reservar mesas de forma sencilla y a los administradores gestionar la disponibilidad y estadísticas en tiempo real.

---

## 🚀 Funcionalidades principales

### 👤 Usuarios
- Registro e inicio de sesión
- Gestión de reservas personales
- Visualización de historial de reservas
- Eliminación y modificación de reservas

### 🏛️ Sistema de reservas
- Selección dinámica de biblioteca → sala → mesa
- Control de disponibilidad
- Creación de reservas en tiempo real (AJAX + Fetch API)
- Eliminación instantánea sin recarga completa

### 📊 Panel de administración
- Estadísticas en tiempo real:
  - Total de reservas
  - Total de usuarios
  - Total de mesas
  - Reservas del día
- Dashboard dinámico con actualización mediante API
- Visualización de actividad del sistema

---

## 🧠 Arquitectura del proyecto

El proyecto está construido sin frameworks backend completos (como Laravel o Symfony), utilizando una arquitectura MVC ligera propia.

---

## 📁 Estructura del proyecto
```
│   .gitignore
│   LICENSE
│   README.md
│
├───app
│   ├───controllers
│   │       AdminController.php
│   │       ApiController.php
│   │       AuthController.php
│   │       MesaController.php
│   │       ReservaController.php
│   │       SalaController.php
│   │
│   ├───middleware
│   │       AdminMiddleware.php
│   │       AuthMiddleware.php
│   │
│   ├───models
│   │       Biblioteca.php
│   │       Estadistica.php
│   │       Mesa.php
│   │       Reserva.php
│   │       Sala.php
│   │       Usuario.php
│   │
│   ├───services
│   │       AuthService.php
│   │       DashboardService.php
│   │       MesaService.php
│   │       ReservaService.php
│   │       SalaService.php
│   │
│   └───views
│       ├───auth
│       │       login.php
│       │       registro.php
│       │
│       ├───dashboard
│       │       admin.php
│       │       usuario.php
│       │
│       ├───layouts
│       │       footer.php
│       │       header.php
│       │
│       └───reservas
│               crear.php
│               editar.php
│               mis_reservas.php
│
├───config
│       database.php
│
├───core
│       BaseController.php
│       helpers.php
│       Model.php
│       Router.php
│
├───database
│       seed.sql
│       studyspace.sql
│
├───public
│       .htaccess
│       index.php
│
├───resources
│   └───js
│           dashboard.js
│           notifications.js
│           reservas.js
│           ui-system.js
│
├───routes
│       api.php
│       web.php
│
└───storage
```

---

## 🛠️ Stack tecnológico

| Tecnología | Descripción |
|------------|-------------|
| PHP 8 | Backend y lógica del servidor |
| MySQL (XAMPP) | Base de datos relacional |
| JavaScript (Vanilla) | Interactividad en el frontend |
| Fetch API | Comunicación asíncrona (AJAX) |
| Tailwind CSS | Diseño y estilos de la interfaz |
| Apache (XAMPP) | Servidor web local |

---

## ⚙️ Configuración de base de datos

El proyecto utiliza MySQL en puerto **3307**.

```php
private const HOST = "127.0.0.1";
private const USER = "root";
private const PASSWORD = "";
private const DBNAME = "studyspace";
private const PORT = 3307;
```

## 📡 API endpoints principales

### Auth
- `/login`
- `/registro`
- `/logout`

### Reservas
- `/mis-reservas`
- `/guardar-reserva`
- `/actualizar-reserva`
- `/eliminar-reserva`

### API REST
- `/api/stats` → estadísticas dashboard
- `/api/salas`
- `/api/mesas`
- `/api/mis-reservas`
- `/api/bibliotecas-tree`

---

## ⚡ Actualización en tiempo real

El sistema utiliza `fetch()` para actualizar datos sin recargar la página:

- Eliminación instantánea de reservas  
- Refresco automático del dashboard  
- Actualización dinámica de listas de reservas  

---

## 🧩 Problema técnico conocido (resuelto)

El frontend no se actualiza automáticamente si no se refresca la vista porque:

- Se usa DOM manual + `fetch`
- Se resuelve con:
  - `refrescarDashboard()`
  - `refrescarReservas()`
  - actualización directa del DOM tras acciones CRUD  

---

## 📸 Capturas del sistema

*(Añadir imágenes aquí)*

- Login  
- Dashboard admin  
- Mis reservas  
- Crear reserva  

---

## 🔧 Instalación y ejecución

1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/studyspace.git
```

2. Copiar proyecto en:
```
C:/xampp/htdocs/studyspace
```

3. Iniciar servicios:
- Apache
- MySQL

4. Crear base de datos:
```
studyspace
```

5. Importar estructura SQL (si aplica)

6. Acceder:
```
http://localhost/studyspace/public/
```

---

## 👨‍💻 Autor

Proyecto desarrollado por **Álvaro Mozo Gaspar**  
Proyecto Final del Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW)
IES Playamar