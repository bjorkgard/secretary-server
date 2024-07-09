<?php

namespace App\Http\Controllers;

use App\Mail\FixMailResponse;
use App\Models\MailResponse;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailResponseController extends Controller
{
    public function complained(Request $request)
    {
        $event = $request->input('event-data');

        $report = Report::where('publisher_email', $event['recipient'])->with('serviceGroup')->first();

        if($report){
            MailResponse::create([
                'identifier' => $report->serviceGroup->identifier,
                'publisher_email' => $event['recipient'],
                'event' => $event['event'],
                'data' => json_encode($event),
            ]);
        }

        return '';
    }

    public function unsubscribed(Request $request)
    {
        $event = $request->input('event-data');

        $report = Report::where('publisher_email', $event['recipient'])->with('serviceGroup')->first();

        if ($report) {
            MailResponse::create([
                'identifier' => $report->serviceGroup->identifier,
                'publisher_email' => $event['recipient'],
                'event' => $event['event'],
                'data' => json_encode($event),
            ]);
        }

        return '';
    }

    public function fail(Request $request)
    {
        $event = $request->input('event-data');

        $report = Report::where('publisher_email', $event['recipient'])->with('serviceGroup')->first();

        if ($report) {
            MailResponse::create([
                'identifier' => $report->serviceGroup->identifier,
                'publisher_email' => $event['recipient'],
                'event' => 'failed',
                'description' => substr(!is_null($event['delivery-status']['message']) ? $event['delivery-status']['message'] : $event['delivery-status']['description'], 0, 255),
                'data' => json_encode($event),
            ]);
        }

        return '';
    }

    public function fixWarning(Request $request){
        $test = MailResponse::where('publisher_email', $request->input('email'))->update(['fix' => true]);

        // Send email to administrator
        Mail::to(env('MAIL_TO_ADDRESS'))->queue(new FixMailResponse($request->input('email')));

        return response()->json([
            'message' => __('mailresponse.fix_warning'),
        ], 201);
    }

    public function getWarnings($identifier)
    {
        $warnings = MailResponse::where('identifier', $identifier)
            ->selectRaw('publisher_email, ANY_VALUE(description) as description, ANY_VALUE(event) as event, ANY_VALUE(data) as data, ANY_VALUE(fix) as fix, ANY_VALUE(id) as id, MIN(created_at) as created_at')
            ->groupBy('publisher_email')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $warnings,
        ], 201);
    }

    public function deleteWarning(Request $request)
    {
        MailResponse::where('publisher_email', $request->input('email'))->delete();

        return response()->json([
            'message' => __('mailresponse.delete_warning'),
        ], 201);
    }
}
