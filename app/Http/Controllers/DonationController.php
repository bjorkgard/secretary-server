<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index($year = null)
    {
        if(!$year){
            $year = date('Y');
        }

        $donations = DB::table('donations')->whereYear('date', $year)->orderBy('date', 'asc')->get();
        $hasPrevious = DB::table('donations')->whereYear('date', intval($year) - 1)->exists();
        $hasNext = DB::table('donations')->whereYear('date', intval($year) + 1)->exists();

        return response()->json([
            'donations' => $donations,
            'currentYear' => $year,
            'hasNext' => $hasNext,
            'hasPrevious' => $hasPrevious
        ], 200);
    }

    public function getDonations($year = null)
    {
        if(!$year){
            $year = date('Y');
        }

        $donations = DB::table('donations')->whereYear('date', $year)->orderBy('date', 'asc')->get();
        $hasPrevious = DB::table('donations')->whereYear('date', intval($year) - 1)->exists();
        $hasNext = DB::table('donations')->whereYear('date', intval($year) + 1)->exists();

        return Inertia::render('Donations/Show', [
            'donations' => $donations,
            'currentYear' => $year,
            'hasNext' => $hasNext,
            'hasPrevious' => $hasPrevious
        ]);
    }

    public function create()
    {
        return Inertia::render('Donations/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|string',
            'amount' => [
                'required',
                'numeric',
                Rule::when($request->type == 'DONATION', 'min:0'),
                Rule::when($request->type == 'COST', 'max:0')],
            'description' => 'required|string'
        ]);

        $donation = Donation::create($request->all());
        $year = $donation->date->format('Y');

        return redirect()->route('donations', ['year' => $year]);
    }

    public function destroy(Donation $donation)
    {
        $year = $donation->date->format('Y');
        $donation->delete();

        return redirect()->route('donations', ['year' => $year]);
    }
}
