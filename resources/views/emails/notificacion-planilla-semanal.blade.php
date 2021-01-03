@component('mail::message')
# Notificación

No olvides llenar tu planilla semanal de asistencia

@component('mail::button', ['url' => route('planillas.semanal.' . $type, $user->codSis)])
Planilla Semanal
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
