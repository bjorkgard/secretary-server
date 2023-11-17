<?php

namespace App\Http\Controllers;

use App\Http\Requests\CongregationRequest;
use App\Models\Congregation;

class CongregationController extends Controller
{
    private $congregation;

    public function __construct(Congregation $congregation)
    {
        $this->congregation = $congregation;
    }

    public function upsert(CongregationRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($this->congregation->where('identifier', $validated['identifier'])->exists()) {
                return $this->update($validated);
            } else {
                return $this->create($validated);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('congregation.upsert_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function create(array $validated)
    {
        $congregation = $this->congregation->create($validated);

        return response()->json([
            'message' => __('congregation.created_successfully'),
            'data' => $congregation,
        ], 201);
    }

    private function update(array $validated)
    {
        $congregation = $this->congregation->where('identifier', $validated['identifier'])->update($validated);

        return response()->json([
            'message' => __('congregation.updated_successfully'),
            'data' => $congregation,
        ], 201);
    }

    public function delete(string $identifier)
    {
        try {
            $congregation = $this->congregation->where('identifier', $identifier)->first();

            if ($congregation) {
                $congregation->delete();
            }

            return response()->json([
                'message' => __('congregation.deleted_successfully'),
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('congregation.deletion_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
