@component('mail::message')
# {{ __('emails.reports.publisherSubject', ['month' => $month]) }}

{{ __('emails.reports.publisher', ['name' => $name]) }}

@component('mail::button', ['url' => $url])
{{ __('emails.reports.button') }}
@endcomponent

{{ __('emails.reports.disclaimer', ['link' => $url]) }}
@endcomponent
