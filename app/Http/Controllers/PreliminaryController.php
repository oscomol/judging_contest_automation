<?php

namespace App\Http\Controllers;
use App\Models\Contestant;
use App\Models\Preliminary;
use Illuminate\Http\Request;
use DB;

class PreliminaryController extends Controller
{
    public function index()
    {
        $id = session('event_id');
        $accessCode = session('access_code');

        $contestants = Contestant::where('eventID', $id)
            ->with(['preliminary' => function ($query) use ($accessCode) {
                $query->where('judgesCode', $accessCode)
                    ->select('contestantID', 'poise', 'projection');
            }])->get();

        $mappedContestants = $contestants->map(function ($con) {
            $con->poise = null;
            $con->projection = null;
            $con->total = null;
    
            if ($con->preliminary) {
                $con->poise = $con->preliminary->poise;
                $con->projection = $con->preliminary->projection;
                $con->total = $con->poise + $con->projection;
            }
    
            return $con;
        });
    
        $isRecorded = $mappedContestants->filter(function ($con) {
            return $con->poise === null;
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

        return view('jcaJudges.pages.pre.index', [
            'contestants' => $sortedContestants->sortBy('contestantNum'),
            'isRecorded' => $isRecorded,
        ]);
    }

            public function store(Request $request){
            
            $data = $request->input('data', []); 

            $preliminaries = [];

            foreach ($data as $item) {
                $preliminaries[] = [
                    'contestantID' => $item['contestantID'],
                    'poise' => $item['poise'],
                    'projection' => $item['projection'],
                    'judgesCode' => session('access_code'),
                    'eventID' => session('event_id'),
                ];
            }

            Preliminary::insert($preliminaries);
            return response()->json('Records inserted successfully');
        }

        public function updateScore(Request $request){

            $accessCode = session('access_code');
 
        $data = $request->input('data', []);

        $gownIdsToUpdate = [];
    
        foreach ($data as $item) {
            $contestantID = $item['contestantID'];
            $poise = $item['poise'];
            $projection = $item['projection'];
    
            Preliminary::where('judgesCode', $accessCode)
                ->where('contestantID', $contestantID)
                ->update([
                    'poise' => $poise,
                    'projection' => $projection,
                ]);
            $gownIdsToUpdate[] = $contestantID;
        }

        return response()->json('Records updated successfully');
            
        }
}
