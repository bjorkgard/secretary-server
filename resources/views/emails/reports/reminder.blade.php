@component('mail::message')
# {{ __('emails.reports.serviceGroupReminder', ['serviceGroup' => $name]) }}

{{ __('emails.reports.missingReports') }}

@component('mail::table')
| {{ __('common.name') }} | {{ __('common.email') }} |
| :------------ | --------:|
@foreach($serviceGroup->reports as $report)
@if(!$report->has_been_in_service && !$report->has_not_been_in_service )
| {{$report->publisher_name}} | [{{$report->publisher_email}}](mailto:{{$report->publisher_email}}) |
@endif
@endforeach
@endcomponent


@component('mail::button', ['url' => $url])
{{ __('emails.reports.button') }}
@endcomponent

{{ __('emails.reports.disclaimer', ['link' => $url]) }}
@endcomponent
