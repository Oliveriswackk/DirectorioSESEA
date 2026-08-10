<x-mail::message>
# Nueva Solicitud de Registro

Se ha registrado un nuevo usuario en el **Directorio Institucional (SESEA)** esperando autorización.

**Datos del solicitante:**
- **Nombre:** {{ $user->name }}
- **Correo:** {{ $user->email }}
- **Fecha de registro:** {{ $user->created_at->format('d/m/Y H:i') }}

---

### Instrucciones:
Para otorgarle acceso al sistema, ingresa a la base de datos y cambia el estatus de la columna `activo` a **`1`** para este usuario.

```text
   |\---/|
   | ,_, |
    \_`_/-..----.
 ___/ `   ' ,""+ \  
(__...'   __\    |`.___.';
  (_,...'(_,.`__)/'.....+
```
Atentamente,

{{ config('mail.from.name') }}
</x-mail::message>