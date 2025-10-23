# Sistema PQRS - CakePHP 5.x

Un sistema completo de gestión de PQRS (Peticiones, Quejas, Reclamos y Sugerencias) desarrollado con CakePHP 5.x.

## Características

### 🔐 Autenticación y Roles
- **Solicitantes (Requesters)**: Pueden crear y consultar sus propios PQRS
- **Agentes**: Pueden gestionar PQRS asignados, responder y crear notas internas
- **Administradores**: Acceso completo al sistema, gestión de usuarios y categorías

### 📋 Funcionalidades Principales

#### Para Usuarios Anónimos
- ✅ Crear PQRS sin necesidad de registro
- ✅ Consultar estado de PQRS por número de ticket
- ✅ Registro de nuevos usuarios

#### Para Usuarios Registrados (Solicitantes)
- ✅ Crear PQRS con información pre-llenada
- ✅ Ver historial completo de sus PQRS
- ✅ Seguimiento detallado del estado

#### Para Agentes
- ✅ Dashboard con estadísticas
- ✅ Gestión de PQRS asignados
- ✅ Responder PQRS con notas públicas e internas
- ✅ Asignación automática o manual
- ✅ Cambio de estados y prioridades

#### Para Administradores
- ✅ Dashboard completo con métricas
- ✅ Gestión de todos los PQRS
- ✅ Administración de usuarios
- ✅ Gestión de categorías
- ✅ Asignación de agentes

### 🎨 Interfaz de Usuario
- ✅ Diseño responsivo con Bootstrap 5
- ✅ Navegación intuitiva separada por roles
- ✅ Indicadores visuales de estado y prioridad
- ✅ Alertas para PQRS vencidos
- ✅ Formularios modernos con validación

## Instalación y Configuración

### Requisitos
- PHP 8.1+
- MySQL 5.7+
- Composer
- Extensiones PHP: mbstring, intl, pdo_mysql

### Configuración de la Base de Datos

1. **Crear base de datos:**
```sql
CREATE DATABASE pqrs_system;
CREATE USER 'pqrs_user'@'localhost' IDENTIFIED BY 'pqrs_password';
GRANT ALL PRIVILEGES ON pqrs_system.* TO 'pqrs_user'@'localhost';
FLUSH PRIVILEGES;
```

2. **Ejecutar migraciones:**
```bash
cd /workspace/pqrs-system
bin/cake migrations migrate
```

### Iniciar el Servidor

```bash
cd /workspace/pqrs-system
php -S localhost:8000 -t webroot/
```

Acceder a: http://localhost:8000

## Usuarios de Prueba

El sistema incluye usuarios de prueba con diferentes roles:

| Rol | Email | Contraseña | Descripción |
|-----|-------|------------|-------------|
| Admin | admin@pqrs.com | password | Acceso completo al sistema |
| Agente | agente@pqrs.com | password | Gestión de PQRS asignados |
| Usuario | usuario@pqrs.com | password | Creación y seguimiento de PQRS |

## Estructura del Sistema

### Modelos Principales
- **Users**: Gestión de usuarios y autenticación
- **Categories**: Categorías para clasificar PQRS
- **Pqrs**: Entidad principal del sistema
- **PqrsResponses**: Respuestas y seguimiento

### Controladores
- **UsersController**: Autenticación y registro
- **PqrsController**: CRUD de PQRS y consultas públicas
- **AdminController**: Panel administrativo
- **PqrsResponsesController**: Gestión de respuestas

### Características Técnicas
- ✅ Autenticación con CakePHP Authentication Plugin
- ✅ Validaciones robustas en modelos
- ✅ Generación automática de números de ticket
- ✅ Cálculo automático de fechas de vencimiento
- ✅ Relaciones de base de datos optimizadas
- ✅ Middleware de seguridad

## Flujo de Trabajo

### 1. Creación de PQRS
- Usuario anónimo o registrado crea PQRS
- Sistema genera número de ticket único
- Se calcula fecha de vencimiento según prioridad
- Notificación al usuario con número de seguimiento

### 2. Asignación y Gestión
- Agentes pueden auto-asignarse PQRS no asignados
- Administradores pueden asignar a cualquier agente
- Cambio de estado automático al asignar

### 3. Respuesta y Seguimiento
- Agentes responden con notas públicas o internas
- Sistema de seguimiento completo
- Resolución y cierre de casos

### 4. Consulta Pública
- Consulta por número de ticket sin autenticación
- Historial completo de respuestas públicas
- Estado actual y fechas importantes

## Seguridad

- ✅ Autenticación basada en sesiones
- ✅ Protección CSRF habilitada
- ✅ Validación de permisos por rol
- ✅ Hash seguro de contraseñas
- ✅ Sanitización de datos de entrada

## Personalización

El sistema está diseñado para ser fácilmente personalizable:

- **Categorías**: Agregar/modificar desde panel admin
- **Estados**: Configurables en el modelo Pqr
- **Prioridades**: Modificables con días de vencimiento
- **Estilos**: CSS personalizable en `/webroot/css/custom.css`

## Tecnologías Utilizadas

- **Backend**: CakePHP 5.x
- **Base de Datos**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Autenticación**: CakePHP Authentication Plugin
- **Migraciones**: CakePHP Migrations Plugin

## Estructura de Archivos

```
pqrs-system/
├── config/
│   ├── Migrations/          # Migraciones de base de datos
│   ├── app.php             # Configuración principal
│   └── routes.php          # Rutas del sistema
├── src/
│   ├── Controller/         # Controladores
│   ├── Model/             # Modelos y entidades
│   └── Application.php    # Configuración de aplicación
├── templates/             # Vistas del sistema
│   ├── Users/            # Vistas de autenticación
│   ├── Pqrs/             # Vistas de PQRS
│   ├── Admin/            # Panel administrativo
│   └── layout/           # Layouts principales
└── webroot/
    ├── css/              # Estilos personalizados
    └── index.php         # Punto de entrada
```

## Licencia

Este proyecto está desarrollado con fines educativos y de demostración.

---

**Desarrollado con CakePHP 5.x** 🍰