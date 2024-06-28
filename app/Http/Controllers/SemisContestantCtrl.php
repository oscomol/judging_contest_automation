<?php

namespace App\Http\Controllers;
use App\Models\SemisContetant;
use Illuminate\Http\Request;

class SemisContestantCtrl extends Controller
{
    public function store(Request $request)
    {
        try {
            foreach ($request->data as $item) {
                SemisContetant::create([
                    'contestantID' => $item['contestantID'],
                    'rank' => $item['rank'],
                    'eventID' => $item['eventID'],
                    'category' => $item['category']
                ]);
            }
            return response()->json(['message' => 'Records inserted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to insert records', 'message' => $e->getMessage()], 500);
        }
    }
    
}
