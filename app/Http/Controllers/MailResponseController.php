<?php

namespace App\Http\Controllers;

use App\Models\MailResponse;
use App\Models\Report;
use Illuminate\Http\Request;

class MailResponseController extends Controller
{
    public function complained(Request $request)
    {
        $event = $request->input('event-data');

        $report = Report::where('publisher_email', $event['recipient'])->first();

        if($report){
            MailResponse::create([
                'identifier' => $report->identifier,
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

        $report = Report::where('publisher_email', $event['recipient'])->first();

        if ($report) {
            MailResponse::create([
                'identifier' => $report->identifier,
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

        $report = Report::where('publisher_email', $event['recipient'])->first();

        if ($report) {
            MailResponse::create([
                'identifier' => $report->identifier,
                'publisher_email' => $event['recipient'],
                'event' => 'failed',
                'description' => substr(!is_null($event['delivery-status']['message']) ? $event['delivery-status']['message'] : $event['delivery-status']['description'], 0, 255),
                'data' => json_encode($event),
            ]);
        }

        return '';
    }

    public function fixWarning($id){
        $mailResponse = MailResponse::find($id);
        $mailResponse->fix = true;
        $mailResponse->save();

        return response()->json([
            'message' => __('mailresponse.fix_warning'),
        ], 201);

    }
}
