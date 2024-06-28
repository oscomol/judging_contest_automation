<?php
namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Judge;
use App\Models\Event;
use App\Models\Preliminary;
use Illuminate\Http\Request;
use DB;

class PreliminaryAdminCtrl extends Controller
{
    public function index(Request $request){

        $eventId = $request->event;

        $event = Event::find($eventId);

        return view("facilitator.singleEvent.ratings.preliminary.index", [
            'event' => $event
        ]);
    }
    public function getIndex(Request $request)
    {
        $eventId = $request->event;
    
        $contestants = Contestant::where('eventID', $eventId)->get();

        $judges = Judge::where('eventID', $eventId)
                        ->where('category', 'Preliminary')
                        ->get();
    
        $mappedContestants = $contestants->map(function($contestant) use ($judges) {
            $totalScores = [];
            $totalRate = 0;
    
            foreach ($judges as $judge) {
                $contestantScores = Preliminary::where('contestantID', $contestant->id)
                                                ->where('judgesCode', $judge->accessCode)
                                                ->select('poise', 'projection')
                                                ->first();
    
                if ($contestantScores) {
                    $individualTotal = $contestantScores->projection + $contestantScores->poise;
                    $totalScores[] = $individualTotal;
                    $totalRate += $individualTotal;
                } else {
                    $totalScores[] = 0;
                }
            }
    
            $contestant->total = $totalScores;
            $contestant->totalRate = $judges->count() > 0 ? round(($totalRate / $judges->count()), 2) : 0;
    
            return $contestant;
        });
    
        $mappedContestants = $mappedContestants->sortByDesc('totalRate');
        $rank = 1;
        $prevTotal = null;
        
        $mappedContestants->each(function ($con) use (&$rank, &$prevTotal) {
            if ($con->totalRate !== null) {
                if ($prevTotal !== null && $con->totalRate < $prevTotal) {
                    $rank++;
                }
                $con->rank = $rank;
                $prevTotal = $con->totalRate;
            } else {
                $con->rank = '?';
            }
        });

        $mappedContestants = $mappedContestants->sortBy('contestantNum');
    
        $response = [
            'contestants' => $mappedContestants->values(),
            'judges' => $judges,
        ];
    
        return response()->json($response);
    }
    
}
