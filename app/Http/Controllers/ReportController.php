<?php

namespace App\Http\Controllers;

use App\Events\PublisherReportedEvent;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class ReportController extends Controller
{
    const EMAIL_STATUS_WAITING = 'WAITING';
    const EMAIL_STATUS_NONE = 'NONE';

    public function update(ReportRequest $request, Report $report)
    {
        $report->update([
            'has_been_in_service' => $request->get('attend') === 'YES' ? true : false,
            'has_not_been_in_service' => $request->get('attend') === 'NO' ? true : false,
            'studies' => $request->get('studies'),
            'auxiliary' => $request->get('auxiliary'),
            'hours' => $request->get('hours'),
            'remarks' => $request->get('remarks'),
            'send_email' => $request->get('send_email'),
            'has_been_updated' => true,
        ]);
    }

    public function updatePublisher(ReportRequest $request, Report $report)
    {
        $report->update([
            'has_been_in_service' => $request->get('attend') === 'YES' ? true : false,
            'has_not_been_in_service' => $request->get('attend') === 'NO' ? true : false,
            'studies' => $request->get('studies'),
            'auxiliary' => $request->get('auxiliary'),
            'hours' => $request->get('hours'),
            'remarks' => $request->get('remarks'),
            'send_email' => $request->get('send_email'),
            'has_been_updated' => true,
        ]);

        // send response to service group
        PublisherReportedEvent::dispatch($report);
    }

    public function send_reports()
    {
        Report::where('send_email', true)
            ->where('email_status', 'NONE')
            ->whereNot('publisher_status', 'INACTIVE')
            ->whereNotNull('publisher_email')
            ->update(['email_status' => 'WAITING']);
    }

    public function updateReport(Request $request)
    {
        $report = Report::where('identifier', $request->get('identifier'))->firstOrFail();

        $report->update([
            'has_been_in_service' => $request->get('hasBeenInService'),
            'has_not_been_in_service' => $request->get('hasNotBeenInService'),
            'studies' => $request->get('studies'),
            'auxiliary' => $request->get('auxiliary'),
            'hours' => $request->get('hours'),
            'remarks' => $request->get('remarks'),
        ]);
    }

    public function show(string $locale, string $identifier)
    {
        $report = Report::where('identifier', $identifier)->firstOrFail();

        return Inertia::render('Reports/Publisher', [
            'report' => $report,
        ]);
    }

    public function getUpdates(string $identifier)
    {
        Log::info('getUpdates', ['identifier' => $identifier]);
        $serviceGroupIds = ServiceGroup::where('identifier', $identifier)->pluck('id');

        $reports = Report::whereIn('service_group_id', $serviceGroupIds)
            ->where('has_been_updated', true)
            ->get();

        Log::info('getUpdates', ['reports' => $reports]);

        return response()->json([
            'data' => $reports,
        ], 201);
    }

    public function resend(string $identifier)
    {
        $report = Report::where('identifier', $identifier)->first();

        if($report){
            $report->email_status = self::EMAIL_STATUS_WAITING;
            $report->save();

            return response()->json([
                'message' => __('report.resend_publisher_report'),
            ], 201);
        }

        return response()->json([
            'message' => __('report.resend_publisher_report_failed'),
        ], 500);
    }

    public function resetUpdated(Request $request)
    {
        Report::whereIn('id', $request->get('ids'))->update(['has_been_updated' => false]);
    }

    public function sendEmail(Report $report)
    {
        $report->update(['email_status' => self::EMAIL_STATUS_WAITING]);
    }

    public function getReportUrl(string $identifier){
        $report = Report::where('identifier', $identifier)->first();

        if($report){
            $url = URL::temporarySignedRoute(
                'publisher-report',
                now()->addDays(20),
                ['locale' => $report->locale, 'report' => $report->identifier]
            );

            return response()->json([
                'url' => $url,
            ], 201);
        }

        return response()->json([
            'message' => __('report.no_report_found'),
        ], 500);
    }
}
