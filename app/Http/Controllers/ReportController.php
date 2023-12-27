<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ReportController extends Controller
{
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

    public function send_reports()
    {
        Report::where('send_email', true)
            ->where('email_status', 'NONE')
            ->whereNot('publisher_status', 'INACTIVE')
            ->whereNotNull('publisher_email')
            ->update(['email_status' => 'WAITING']);
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
        $serviceGroupIds = ServiceGroup::where('identifier', $identifier)->pluck('id');

        $reports = Report::whereIn('service_group_id', $serviceGroupIds)
            ->where('has_been_updated', true)
            ->get();

        return response()->json([
            'data' => $reports,
        ], 201);
    }

    public function resetUpdated(Request $request)
    {
        Report::whereIn('id', $request->get('ids'))->update(['has_been_updated' => false]);
    }

    public function sendEmail(Report $report)
    {
        $report->update(['email_status' => 'WAITING']);
    }
}
