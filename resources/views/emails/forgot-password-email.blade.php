@component('mail::message')
# Solicitud de recuperación de contraseña

Sigue el siguiente enlace para acceder a tu cuenta y actualizar tu contraseña.

@component('mail::button', ['url' => route('recover', $user->forgotPasswordToken)])
Acceder
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
