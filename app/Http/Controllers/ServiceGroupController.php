<?php

namespace App\Http\Controllers;

use App\Models\ServiceGroup;
use Illuminate\Http\Request;

class ServiceGroupController extends Controller
{
    const EMAIL_STATUS_WAITING = 'WAITING';
    const EMAIL_STATUS_NONE = 'NONE';

    public function start(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'identifier' => 'required',
                'locale' => 'required',
                'publishers' => 'required|array',
                'serviceGroups' => 'required|array',
                'serviceMonth' => 'required|array',
            ]);

            $identifier = $validatedData['identifier'];
            $locale = $validatedData['locale'];
            $publishers = $validatedData['publishers'];
            $serviceGroups = $validatedData['serviceGroups'];
            $serviceMonth = $validatedData['serviceMonth'];

            foreach ($serviceGroups as $serviceGroup) {
                $responsible = null;
                $assistant = null;

                if (isset($serviceGroup['responsibleId'])) {
                    $responsible = $this->findPublisherById($publishers, $serviceGroup['responsibleId']);
                }
                if (isset($serviceGroup['assistantId'])) {
                    $assistant = $this->findPublisherById($publishers, $serviceGroup['assistantId']);
                }

                $SG = ServiceGroup::create([
                    'identifier' => $identifier,
                    'locale' => $locale,
                    'service_group_identifier' => $serviceGroup['_id'],
                    'name' => $serviceGroup['name'],
                    'responsible_email' => $responsible ? $responsible['email'] : null,
                    'assistant_email' => $assistant ? $assistant['email'] : null,
                    'email_status' => isset($responsible['email']) || isset($assistant['email']) ? self::EMAIL_STATUS_WAITING : self::EMAIL_STATUS_NONE,
                ]);

                $SG->reports()->createMany($this->findReportsByServiceGroupId($serviceMonth['reports'], $serviceGroup['_id'], $locale));
            }

            return response()->json([
                'message' => __('report.started_successfully'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('report.start_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function findReportsByServiceGroupId($reports, $serviceGroupIdentifier, $locale)
    {
        $filteredReports = [];

        foreach ($reports as $report) {
            if ($serviceGroupIdentifier == $report['publisherServiceGroupId']) {
                $r = [
                    'identifier' => $report['identifier'],
                    'type' => $report['type'],
                    'name' => $report['name'],
                    'has_been_in_service' => $report['hasBeenInService'],
                    'has_not_been_in_service' => $report['hasNotBeenInService'],
                    'studies' => isset($report['studies']) ? $report['studies'] : null,
                    'auxiliary' => $report['auxiliary'],
                    'hours' => isset($report['hours']) ? $report['hours'] : null,
                    'remarks' => isset($report['remarks']) ? $report['remarks'] : null,
                    'publisher_status' => $report['publisherStatus'],
                    'publisher_name' => $report['publisherName'],
                    'publisher_email' => $report['publisherEmail'],
                    'locale' => $locale,
                    'email_status' => self::EMAIL_STATUS_NONE,
                    'send_email' => $report['publisherSendEmail'],
                ];

                $filteredReports[] = $r;
            }
        }

        return $filteredReports;
    }

    private function findPublisherById($array, $id)
    {
        $key = array_search($id, array_column($array, '_id'));
        return $key !== false ? $array[$key] : null;
    }
}
