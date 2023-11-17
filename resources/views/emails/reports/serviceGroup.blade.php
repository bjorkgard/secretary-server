@component('mail::message')
# {{ __('emails.reports.serviceGroupSubject', ['serviceGroup' => $name]) }}

{{ __('emails.reports.servicegroup') }}

@component('mail::button', ['url' => $url])
{{ __('emails.reports.button') }}
@endcomponent

{{ __('emails.reports.disclaimer', ['link' => $url]) }}
@endcomponent
