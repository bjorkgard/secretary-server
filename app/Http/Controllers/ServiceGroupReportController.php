<?php

namespace App\Http\Controllers;

use App\Models\Congregation;
use App\Models\ServiceGroup;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ServiceGroupReportController extends Controller
{
    public function show(string $locale, string $identifier)
    {
        app()->setLocale($locale);

        $serviceGroup = ServiceGroup::where('service_group_identifier', $identifier)->with('reports')->firstOrFail();
        $congregation = Congregation::where('identifier', $serviceGroup->identifier)->firstOrFail();


        return Inertia::render('Reports/ServiceGroup', [
            'congregation' => $congregation,
            'serviceGroup' => $serviceGroup,
        ]);
    }
}
