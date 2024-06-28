<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\Gown;
use App\Models\Preliminary;
use App\Models\Swimwear;
use Illuminate\Http\Request;
use App\Models\SemisContetant;

class RankingCtrl extends Controller
{
    public function index(Request $request) {


        $eventID = $request->event;
        $event = Event::find($eventID);

        return view('facilitator.singleEvent.ratings.ranking.index', [
            'event' => $event,
        ]);
    }

    public function getIndex(Request $request)
    {
        $eventID = $request->event;
        $contestants = Contestant::where('eventID', $eventID)->get();
    
        $mappedContestants = $contestants->map(function ($con) use ($eventID) {
            $preliminaryRate = Preliminary::where('contestantID', $con->id)->where('eventID', $eventID)->select('poise', 'projection')->get();
            $swimwearRate = Swimwear::where('contestantID', $con->id)->where('eventID', $eventID)->select('suitability', 'projection')->get();
            $gownRate = Gown::where('contestantID', $con->id)->where('eventID', $eventID)->select('suitability', 'projection')->get();

            $class = SemisContetant::where('contestantID', $con->id)
            ->where('category', 'semi')
            ->get();
    
            $preliminary = 0;
            $swimwear = 0;
            $gown = 0;
    
            foreach ($preliminaryRate as $rate) {
                $preliminary += $rate->poise + $rate->projection;
            }
    
            foreach ($swimwearRate as $rate) {
                $swimwear += $rate->suitability + $rate->projection;
            }
    
            foreach ($gownRate as $rate) {
                $gown += $rate->suitability + $rate->projection;
            }

            if($class->isNotEmpty()){
                $con->class ="bg-none";
            }else{
                $con->class ="";
            }
    
            $con->preliminary = $preliminary;
            $con->swimwear = $swimwear;
            $con->gown = $gown;
    
            return $con;
        });
    
        $mappedContestants = $mappedContestants->sortByDesc('preliminary')->values();
        $rank = 1;
        $prevTotal = null;
        $mappedContestants->transform(function ($con) use (&$rank, &$prevTotal) {
            if ($con->preliminary > 0) {
                if ($prevTotal !== null && $con->preliminary < $prevTotal) {
                    $rank++;
                }
                $con->preliminaryRank = $rank;
                $prevTotal = $con->preliminary;
            } else {
                $con->preliminaryRank = '?';
            }
            return $con;
        });
    
        $mappedContestants = $mappedContestants->sortByDesc('swimwear')->values();
        $rank = 1;
        $prevTotal = null;
        $mappedContestants->transform(function ($con) use (&$rank, &$prevTotal) {
            if ($con->swimwear > 0) {
                if ($prevTotal !== null && $con->swimwear < $prevTotal) {
                    $rank++;
                }
                $con->swimwearRank = $rank;
                $prevTotal = $con->swimwear;
            } else {
                $con->swimwearRank = '?';
            }
            return $con;
        });
    
        $mappedContestants = $mappedContestants->sortByDesc('gown')->values();
        $rank = 1;
        $prevTotal = null;
        $mappedContestants->transform(function ($con) use (&$rank, &$prevTotal) {
            if ($con->gown > 0) {
                if ($prevTotal !== null && $con->gown < $prevTotal) {
                    $rank++;
                }
                $con->gownRank = $rank;
                $prevTotal = $con->gown;
            } else {
                $con->gownRank = '?';
            }
            return $con;
        });
    
        $mappedContestants->transform(function ($con) {
            $total = 0;
            if ($con->preliminaryRank > 0) {
                $total += $con->preliminaryRank;
            }
            if ($con->swimwearRank > 0) {
                $total += $con->swimwearRank;
            }
            if ($con->gownRank > 0) {
                $total += $con->gownRank;
            }
            $con->total = $total;
            return $con;
        });

        $mappedContestants = $mappedContestants->sortBy('total')->values();
        $rank = 1;
        $prevTotal = null;
        $mappedContestants->transform(function ($con) use (&$rank, &$prevTotal) {
            if ($con->total > 0) {
                if ($prevTotal !== null && $con->total > $prevTotal) {
                    $rank++;
                }
                $con->overallRank = $rank;
                $prevTotal = $con->total;
            } else {
                $con->overallRank = '?';
            }
            return $con;
        });

        $mappedContestants = $mappedContestants->sortBy('contestantNum');

        $data = [
            'contestants' => $mappedContestants->values()
        ];
    
        return response()->json($data);
    }
    
}


