<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunicationRequest;
use App\Models\Communication;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    private $communication;

    public function __construct(Communication $communication)
    {
        $this->communication = $communication;
    }

    public function create(CommunicationRequest $request){
        try{
            $validated = $request->validated();
            $data = $this->communication->create($validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Communication creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }


        return response()->json([
            'message' => 'Communication created successfully',
        ], 201);
    }

    public function delete($id){
        try{
            $this->communication->where('id', $id)->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Communication deletion failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Communication deleted successfully',
        ], 201);
    }

    public function getCommunications(string $identifier){
        $data = $this->communication->where('identifier', $identifier)->get();

        return response()->json([
            'message' => 'Communications retrieved successfully',
            'data' => $data
        ], 200);
    }
}
