<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function getInformations($identifier)
    {
        $informations = Information::where('identifier', $identifier)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $informations,
        ], 201);
    }

    public function deleteInformation(Request $request)
    {
        Information::where('id', $request->input('id'))->delete();

        return response()->json([
            'message' => __('information.delete_message'),
        ], 201);
    }
}
