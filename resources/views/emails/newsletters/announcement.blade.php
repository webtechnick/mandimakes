@component('mail::message')
# Mandi Makes Announcement

{!! $content !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
