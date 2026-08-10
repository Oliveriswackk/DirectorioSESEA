# Directorio Institucional SESEA

```text
           __..--''``---....___   _..._    __
 /// //_.-'    .-/";  `        ``<._  ``.''_ `. / // /
///_.-' _..--.'_    \                    `( ) ) // //
/ (_..-' // (< _     ;_..__               ; `' / ///
 / // // //  `-._,_)' // / ``--...____..-' /// / //
```

Sistema web desarrollado para la gestión centralizada de información institucional de la Secretaría Ejecutiva del Sistema Estatal Anticorrupción del Estado de Chihuahua.

Permite administrar la estructura institucional (entes, sedes y catálogos) y la información operativa de contactos y asignaciones desde una única plataforma.

---

## Características

- Administración de catálogos institucionales.
- Gestión de entes y sedes.
- Directorio de contactos.
- Historial de asignaciones.
- Bitácora de cambios.
- **Control de acceso y Autoregistro:** solicitud de cuentas de usuario con notificación automática por correo electrónico al área de sistemas.
- Arquitectura basada en Laravel 12.

---

## Arquitectura

El modelo de datos se organiza en dos dominios claramente diferenciados.

### Catálogos

Información estructural utilizada por todo el sistema.

```text
Estados
Municipios
Niveles de Gobierno
Entes
Sedes
Puestos
Roles
```

### Operación

Información generada durante el uso diario del sistema.

```text
Contactos
Asignaciones
Bitácora
Usuarios (con estatus de activación y blindaje de seguridad)
```

Esta separación permite mantener la estructura institucional independiente de la información operativa.

---

## Tecnologías

| Tecnología       | Versión   |
|------------------|-----------|
| PHP              | 8.3       |
| Laravel          | 12        |
| MySQL / MariaDB  | 8.0+      |
| Bootstrap        | SB Admin 2|
| Vite             | —         |
| SweetAlert2      | —         |
| Select2          | —         |

---

## Instalación

### Clonar el proyecto

```bash
git clone https://github.com/Oliveriswackk/DirectorioSESEA.git
cd DirectorioSESEA
```

### Instalar dependencias

```bash
composer install
npm install
```

### Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env` con las credenciales de la base de datos y la configuración de correo para las notificaciones de registro:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=directorio_v2
DB_USERNAME=******
DB_PASSWORD=******

# Configuración de correo para solicitudes de acceso
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io # O smtp.gmail.com
MAIL_PORT=2525
MAIL_USERNAME=******
MAIL_PASSWORD=******
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu correo"
MAIL_FROM_NAME="Departamento de Sistemas - Directorio Interno"
```

### Crear la base de datos

```bash
php artisan migrate --seed
```

> **Nota:** los nuevos usuarios registrados requerirán que la columna `activo` se cambie a `1` directamente en la base de datos, o que el administrador les otorgue acceso.

### Compilar recursos

**Desarrollo**

```bash
npm run dev
```

**Producción**

```bash
npm run build
```

### Ejecutar

```bash
php artisan serve
```

La aplicación estará disponible en [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Estructura del proyecto

```text
app/
    Http/
    Models/
    Services/
database/
    migrations/
    seeders/
resources/
    views/
    js/
    css/
```

---

## Consideraciones

- El repositorio no incluye información institucional real.
- Los datos operativos utilizados en producción no forman parte del proyecto.
- Los seeders únicamente generan la información necesaria para un entorno de desarrollo.

---

## Licencia

Proyecto desarrollado para la Secretaría Ejecutiva del Sistema Estatal Anticorrupción del Estado de Chihuahua. Diseñado para pruebas y despliegue rápido.