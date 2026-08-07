# Directorio Institucional SESEA

Sistema web desarrollado para la gestión centralizada de información institucional de la Secretaría Ejecutiva del Sistema Estatal Anticorrupción del Estado de Chihuahua.

Permite administrar la estructura institucional (entes, sedes y catálogos) y la información operativa de contactos y asignaciones desde una única plataforma.

---

# Características

- Administración de catálogos institucionales.
- Gestión de entes y sedes.
- Directorio de contactos.
- Historial de asignaciones.
- Bitácora de cambios.
- Arquitectura basada en Laravel 12.

---

# Arquitectura

El modelo de datos se organiza en dos dominios claramente diferenciados.

## Catálogos

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

## Operación

Información generada durante el uso diario del sistema.

```text
Contactos
Asignaciones
Bitácora
Usuarios
```

Esta separación permite mantener la estructura institucional independiente de la información operativa.

---

# Tecnologías

| Tecnología | Versión |
|------------|----------|
| PHP | 8.3 |
| Laravel | 12 |
| MySQL / MariaDB | 8.0+ |
| Bootstrap | SB Admin 2 |
| Vite | — |
| SweetAlert2 | — |
| Select2 | — |

---

# Instalación

## Clonar el proyecto

```bash
git clone https://github.com/Oliveriswackk/DirectorioSESEA.git

cd DirectorioSESEA
```

## Instalar dependencias

```bash
composer install

npm install
```

## Configurar el entorno

```bash
cp .env.example .env

php artisan key:generate
```

Editar el archivo `.env` con las credenciales de la base de datos.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=directorio_v2
DB_USERNAME=******
DB_PASSWORD=******
```

## Crear la base de datos

```bash
php artisan migrate --seed
```

## Compilar recursos

Desarrollo

```bash
npm run dev
```

Producción

```bash
npm run build
```

## Ejecutar

```bash
php artisan serve
```

La aplicación estará disponible en

```
http://127.0.0.1:8000
```

---

# Estructura del proyecto

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

# Consideraciones

- El repositorio no incluye información institucional real.
- Los datos operativos utilizados en producción no forman parte del proyecto.
- Los seeders únicamente generan la información necesaria para un entorno de desarrollo.

---

# Licencia

Proyecto desarrollado para la Secretaría Ejecutiva del Sistema Estatal Anticorrupción del Estado de Chihuahua.