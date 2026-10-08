# Directorio Institucional SESEA

```text
           __..--''``---....___   _..._    __
 /// //_.-'    .-/";  `        ``<._  ``.''_ `. / // /
///_.-' _..--.'_    \                    `( ) ) // //
/ (_..-' // (< _     ;_..__               ; `' / ///
 / // // //  `-._,_)' // / ``--...____..-' /// / //
```
Sistema web para la consulta y gestión de información de contacto de personas vinculadas con entidades y unidades administrativas.

El proyecto corresponde a la **segunda versión del Directorio Institucional de SESEA**, reconstruida a partir de la experiencia obtenida con la primera versión y de las necesidades reales de operación y mantenimiento.

---

## Contexto

La primera versión del Directorio permitió centralizar información que anteriormente se encontraba distribuida en distintas fuentes.

Sin embargo, con su uso surgieron oportunidades de mejora relacionadas principalmente con la **estructura y complejidad del modelo de datos**, más que con la calidad o disponibilidad de la información.

La V2 no busca simplemente agregar funcionalidades a la versión anterior. Se plantea como una **reconstrucción del modelo**, conservando y adaptando la información existente, pero simplificando las relaciones y priorizando el propósito principal del sistema: **consultar y administrar información de contacto de manera útil, mantenible y trazable**.

La experiencia con la V1 sirvió como base para identificar qué estructuras eran realmente necesarias y cuáles podían simplificarse.

---

## Objetivo

Desarrollar una versión más simple y mantenible del Directorio, centrada en:

* Consulta rápida de información de contacto.
* Relación entre personas y organizaciones.
* Historial de asignaciones.
* Manejo de información parcialmente disponible.
* Trazabilidad de actualizaciones.
* Evolución progresiva del sistema sin reproducir la complejidad de la V1.

---

## Problema

El Directorio no parte de un problema de ausencia de información, sino de cómo **modelarla y mantenerla sin introducir complejidad innecesaria**.

La versión anterior contenía relaciones y estructuras que, aunque funcionales, no siempre correspondían con el uso real del sistema.

Por ello, V2 prioriza la utilidad de la información sobre la representación exhaustiva de toda la estructura institucional.

---

## Modelo principal

El modelo de V2 toma al **Contacto** como concepto central.

```text
                    ┌──────────────┐
                    │   Contacto   │
                    └──────┬───────┘
                           │
                      Asignación
                           │
             ┌─────────────┼─────────────┐
             │             │             │
           Ente          Puesto         Sede
                           │
                    Medio de contacto
```

Una persona puede tener distintas asignaciones a lo largo del tiempo.

Cuando cambia su entidad, puesto o sede, la relación anterior puede cerrarse y conservarse como historial en lugar de sobrescribirse.

Esto permite distinguir entre:

* La persona.
* Su relación institucional actual.
* Sus relaciones institucionales anteriores.
* La información de contacto disponible.

---

## Características principales

### Gestión de contactos

* Registro y consulta de personas.
* Información de contacto.
* Información parcialmente disponible.
* Búsqueda y filtros.
* Consulta rápida desde el listado principal.

### Asignaciones

* Relación entre una persona y su contexto institucional.
* Entidad.
* Puesto.
* Sede.
* Vigencia de la asignación.
* Historial de cambios.

### Catálogos

Administración de información utilizada por el sistema, incluyendo:

* Estados.
* Municipios.
* Entes.
* Sedes.
* Puestos.
* Otros catálogos requeridos por la operación.

### Historial y trazabilidad

Los cambios relevantes conservan información que permite identificar:

* Qué ocurrió.
* Cuándo ocurrió.
* Quién realizó la actualización.
* Fuente o contexto de la información cuando corresponde.

### Búsqueda y consulta

El sistema permite consultar los contactos mediante búsqueda y filtros, con paginación del lado del servidor para evitar cargar innecesariamente toda la información.

### Exportaciones

Información del Directorio puede exportarse para los procesos que lo requieren.

### Bitácora

Las operaciones relevantes pueden registrarse mediante la bitácora interna del sistema.

### API

El sistema expone un endpoint para consultar contactos activos:

```text
GET /api/contactos
```

La API permite realizar búsquedas y devuelve información básica de contacto para integraciones internas.

Actualmente es utilizada por **SCo** como fuente de consulta.

---

## Decisiones de diseño

### Contacto como centro

El Directorio no intenta representar toda la estructura institucional. Su propósito principal es facilitar la consulta de personas y sus medios de contacto.

### Simplicidad sobre exhaustividad

Cada entidad, relación o dato debe justificar su utilidad operacional.

No se busca normalizar o representar información únicamente por razones técnicas si esto no aporta valor al uso del sistema.

### Asignaciones para representar relaciones

La relación institucional se mantiene separada de la información personal.

Esto permite conservar el historial de cambios sin duplicar o sobrescribir innecesariamente la información del contacto.

### Historial

Las asignaciones anteriores pueden mantenerse como inactivas en lugar de eliminarse, permitiendo conocer relaciones institucionales anteriores.

### Información parcial

No todos los contactos disponen de la misma cantidad de información.

El modelo permite conservar un registro útil aun cuando determinados datos secundarios todavía no estén disponibles.

### Trazabilidad

Las actualizaciones deben poder relacionarse con un momento, un usuario y, cuando corresponde, una fuente de información.

---

## Arquitectura

El proyecto utiliza una arquitectura basada en **Laravel MVC**, separando las principales responsabilidades de la aplicación.

```text
Routes
   │
   ▼
Controllers
   │
   ├──────────────► Queries
   │
   └──────────────► Services
                       │
                       ▼
                    Models
                       │
                       ▼
                    Database
```

La aplicación utiliza:

* **Controllers** para manejar las solicitudes y coordinar los procesos.
* **Queries** para operaciones de consulta específicas.
* **Services** para procesos que requieren lógica de aplicación.
* **Models / Eloquent** para representar y acceder a los datos.
* **Blade** para la presentación.
* **Middleware / Policies / permisos** para controlar el acceso.

La separación permite mantener la aplicación organizada y facilita la evolución de sus diferentes componentes.

---

## Integración con SCo

Directorio cuenta con una API interna para proporcionar información básica de contactos.

```text
Directorio
    │
    │ GET /api/contactos
    ▼
   SCo
```

La API permite buscar contactos activos y devuelve información necesaria para la integración.

Ejemplo de búsqueda:

```text
GET /api/contactos?q=nombre
```

La respuesta funciona como un contrato de integración entre ambos sistemas.

---

## Tecnologías

* PHP 8.3+
* Laravel 12
* Eloquent ORM
* MariaDB / MySQL 8.0+
* Blade
* Bootstrap
* SB Admin 2
* JavaScript
* Vite
* DataTables
* TomSelect
* SweetAlert2
* DomPDF
* Laravel Excel

---

# Instalación

## Requisitos

Antes de instalar el proyecto necesitas:

* PHP 8.3 o superior.
* Composer.
* Node.js y npm.
* MariaDB o MySQL 8.0 o superior.
* Git.

Verifica las versiones:

```bash
php -v
composer -V
node -v
npm -v
```

---

## 1. Clonar el repositorio

```bash
git clone <REPOSITORY_URL>
cd <PROJECT_DIRECTORY>
```

---

## 2. Instalar dependencias de PHP

```bash
composer install
```

---

## 3. Instalar dependencias de frontend

```bash
npm install
```

---

## 4. Configurar el entorno

Copia el archivo de configuración:

```bash
cp .env.example .env
```

En Windows también puedes copiar `.env.example` manualmente y renombrarlo como `.env`.

Configura en `.env` los datos de conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=directorio
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

---

## 6. Crear la base de datos

Crea una base de datos vacía con el nombre configurado en `.env`.

Por ejemplo:

```text
directorio
```

---

## 7. Ejecutar migraciones y seeders

Para una instalación limpia de desarrollo:

```bash
php artisan migrate:fresh --seed
```

Esto crea la estructura de la base de datos y carga los datos definidos por los seeders.

> **Nota:** `migrate:fresh` elimina las tablas existentes de la base de datos configurada. No lo utilices sobre una instalación que contenga información que quieras conservar.

---

## 8. Compilar los recursos frontend

Para desarrollo:

```bash
npm run dev
```

Para generar los recursos de producción:

```bash
npm run build
```

---

## 9. Iniciar el servidor

En otra terminal:

```bash
php artisan serve
```

La aplicación estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

---

# Datos de desarrollo

El proyecto incluye seeders para facilitar una instalación de desarrollo y pruebas.

Los datos generados por estos seeders **no representan información institucional real**.

Las credenciales de desarrollo, cuando están definidas por los seeders, deben consultarse directamente en:

```text
database/seeders/
```

No se incluyen credenciales de producción en el repositorio.

---

# Migración de información

La V2 fue diseñada considerando la información existente en la V1.

El proceso contempla:

```text
Información V1
      │
      ▼
Revisión y mapeo
      │
      ▼
Transformación
      │
      ▼
Consolidación
      │
      ▼
Validación
      │
      ▼
Información V2
```

El objetivo no es replicar la estructura anterior, sino **conservar y adaptar la información útil al nuevo modelo**.

---

# Datos institucionales

El repositorio no contiene información institucional real utilizada en producción.

La información incluida para desarrollo y pruebas debe considerarse únicamente como información de ejemplo.

La responsabilidad de mantener actualizada la información institucional corresponde a la institución y a los procesos definidos para ello; el sistema proporciona las herramientas para su administración y trazabilidad.

---

# Documentación

El proyecto cuenta con documentación adicional para profundizar en su funcionamiento.

### Manual Técnico

El **Manual Técnico** está orientado a quienes necesitan comprender o modificar el sistema.

Incluye información sobre:

* Arquitectura.
* Estructura del proyecto.
* Modelo de datos.
* Controladores.
* Queries.
* Services.
* Funcionalidades.
* Reglas de integridad.
* API.
* Integraciones.
* Mantenimiento.
* Puntos críticos del sistema.
* Consideraciones para realizar cambios.

El README está pensado para que una persona pueda **entender, instalar y probar el proyecto sin consultar documentación adicional**.

La documentación técnica sirve como referencia cuando se requiere trabajar directamente sobre el código.

---

# Estado actual

**Versión:** 2.0

La V2 constituye una reconstrucción del Directorio basada en la experiencia obtenida con la primera versión.

El sistema establece una base más simple y mantenible para continuar incorporando capacidades conforme el uso real las justifique.

El proyecto no pretende convertirse en un sistema de Recursos Humanos ni en una plataforma para representar exhaustivamente toda la estructura institucional.

Su función principal continúa siendo la **consulta y administración de información de contacto institucional**.

---

## Mi participación

El desarrollo de Directorio V2 fue realizado por mí de principio a fin.

Mi participación incluyó:

* Análisis de la V1 y de sus limitaciones.
* Rediseño del modelo de datos.
* Definición y documentación de decisiones técnicas.
* Adaptación y migración de información existente.
* Desarrollo del backend y frontend.
* Implementación de contactos y asignaciones.
* Implementación del historial de asignaciones.
* Desarrollo de consultas, búsqueda y filtros.
* Administración de catálogos.
* Autenticación, autorización y permisos.
* Implementación de bitácora.
* Exportaciones.
* Recepción y manejo de archivos.
* Desarrollo de la API.
* Integración con SCo.
* Documentación técnica y operativa.

La reconstrucción de V2 partió de una idea central: **simplificar el sistema sin perder la información ni la trazabilidad obtenidas con la primera versión**.

---

## Licencia

Este proyecto fue desarrollado para uso institucional de SESEA.

La información institucional, configuraciones de producción y demás elementos sensibles no forman parte del repositorio público.
