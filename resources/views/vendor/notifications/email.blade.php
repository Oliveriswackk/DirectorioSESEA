<x-mail::message>
# Recuperación de Contraseña

Has solicitado restablecer tu contraseña para acceder al **Directorio Institucional (SESEA)**.

Haz clic en el siguiente botón para asignar una nueva clave de acceso:

<x-mail::button :url="$actionUrl">
Restablecer Contraseña
</x-mail::button>

Si tú no solicitaste este cambio, puedes ignorar este mensaje de forma segura.

---

```text
            /`·.¸
  o        /¸...¸`:·
  o     ¸.·´  ¸   `·.¸.·´)
    oo : © ):´;      ¸  {
        `·.¸ `·  ¸.·´\`·¸)
            `\\´´\¸.·´
```
Atentamente,

{{ config('mail.from.name') }}
</x-mail::message>