<?php

namespace App\Http\Controllers;
use App\Models\Preliminary;
use App\Models\Swimwear;
use Illuminate\Http\Request;
use App\Models\Contestant;
use DB;

class SwimwearCtrl extends Controller
{
    public function index(){
        $id = session('event_id');
        $accessCode = session('access_code');

        $contestants = Contestant::where('eventID', $id)
        ->with(['swimwear' => function ($query) use ($accessCode) {
            $query->where('judgesCode', $accessCode)
                ->select('contestantID', 'suitability', 'projection');
        }])->get();

    $mappedContestants = $contestants->map(function ($con) {
        $con->suitability = null;
        $con->projection = null;
        $con->total = null;

        if ($con->swimwear) {
            $con->suitability = $con->swimwear->suitability;
            $con->projection = $con->swimwear->projection;
            $con->total = $con->suitability + $con->projection;
        }

        return $con;
    });

    $isRecorded = $mappedContestants->filter(function ($con) {
        return $con->suitability === null;
    })->isEmpty();

    $sortedContestants = $mappedContestants->sortByDesc('total');

    $rank = 1;
    $prevTotal = null;
    $sortedContestants = $sortedContestants->map(function ($con) use (&$rank, &$prevTotal) {
        if ($con->total !== null) {
            if ($prevTotal !== null && $con->total < $prevTotal) {
                $rank++;
            }
            $con->rank = $rank;
            $prevTotal = $con->total;
        } else {
            $con->rank = '?';
        }
        return $con;
    });

    return view('jcaJudges.pages.pre.swimwear', [
       'contestants' => $mappedContestants->sortBy('contestantNum'),
        'isRecorded' => $isRecorded
    ]);
    }

    public function store(Request $request){

        $data = $request->input('data', []); 

        $swimwear = [];

        foreach ($data as $item) {
            $swimwear[] = [
                'contestantID' => $item['contestantID'],
                'suitability' => $item['suitability'],
                'projection' => $item['projection'],
                'judgesCode' => session('access_code'),
                'eventID' => session('event_id'),
            ];
        }

        Swimwear::insert($swimwear);
        return response()->json('Records inserted successfully');
     }

     public function updateScore(Request $request){
        $accessCode = session('access_code');
 
        $data = $request->input('data', []);

        $gownIdsToUpdate = [];
    
        foreach ($data as $item) {
            $contestantID = $item['contestantID'];
            $suitability = $item['suitability'];
            $projection = $item['projection'];
    
            Swimwear::where('judgesCode', $accessCode)
                ->where('contestantID', $contestantID)
                ->update([
                    'suitability' => $suitability,
                    'projection' => $projection,
                ]);
            $gownIdsToUpdate[] = $contestantID;
        }

        return response()->json('Records updated successfully');
     }
}
