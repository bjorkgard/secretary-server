@component('mail::message')
# {{ __('emails.reports.reportResponse', ['month' => $report->name, 'name' => $name]) }}

@component('mail::table')
|  |  |
| :------------ | --------:|
| {{__('page.reports.attend')}} | {{$report->has_been_in_service ? __('common.yes'):  __('common.no')}} |
@if($report->studies)
| {{__('page.reports.studies')}} | {{$report->studies}} |
@endif
@if($report->auxiliary)
| {{__('page.reports.auxiliary')}} | {{$report->auxiliary ? __('common.yes'):  __('common.no')}} |
@endif
@if($report->hours)
| {{__('page.reports.hours')}} | {{$report->hours}} |
@endif
@if($report->remarks)
| {{__('page.reports.remarks')}} | {{$report->remarks}} |
@endif
@endcomponent


@endcomponent
