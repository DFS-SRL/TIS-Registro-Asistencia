@component('mail::message')
# Notificación

No olvides llenar tu planilla diaria de asistencia

@component('mail::button', ['url' => route('planillas.diaria.obtener', $user->codSis)])
Planilla Diaria
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
