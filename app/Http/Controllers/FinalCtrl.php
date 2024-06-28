<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\FinalRate;
use App\Models\Judge;
use App\Models\Semi;
use App\Models\SemisContetant;
use Illuminate\Http\Request;

class FinalCtrl extends Controller
{
    public function indexJudges()
    {
        $eventId = session('event_id');
        $access_code = session('access_code');
    
        $semis = SemisContetant::where('eventID', $eventId)
                               ->where('category', 'final')
                               ->get();
    
        $contestants = $semis->map(function($semi) use ($access_code) {
            $contestant = Contestant::findOrFail($semi->contestantID);
    
            $rating = FinalRate::where('judgesCode', $access_code)
                               ->where('contestantID', $semi->contestantID)
                               ->select('beauty', 'poise', 'projection')
                               ->first();

            $contestant->beauty = $rating ? $rating->beauty : 0;
            $contestant->poise = $rating ? $rating->poise : 0;
            $contestant->projection = $rating ? $rating->projection : 0;
            $contestant->total = $rating ? ($rating->beauty + $rating->projection + $rating->poise) : 0;
    
            return $contestant;
        });

        $contestants = $contestants->sortBy('total');
        $rank = 1;
        $prevTotal = null;

        $contestants = $contestants->sortByDesc('total')->map(function ($con) use (&$rank, &$prevTotal) {
            if ($con->total > 0) {
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

        $ranks = $contestants->filter(function($con){
            return $con->rank !== '?';
        });

        return view('jcaJudges.pages.final.final', [
            'contestants' => $contestants->sortBy('contestantNum'), // Assuming contestantNum exists
            'ranks' => $ranks,
        ]);
    }
    

    public function indexAdmin(Request $request){

        $eventId = $request->event;

        $event = Event::findOrFail($eventId);

        return view('facilitator.singleEvent.ratings.final.final', [
            'event' => $event
        ]);
    }

    public function getAdminIndex(Request $request){
        $eventId = session('event_id');
        $judges = Judge::where('eventID', $eventId)
        ->where('category', 'Final')
        ->get();

                $final = SemisContetant::where('eventID', $eventId)->where('category', 'final')->get();


                $contestants = $final->map(function($con) use ($judges) {
                $contestantDetails = Contestant::findOrFail($con->contestantID);

                $totalRating = [];
                $sumOfRatings = 0;
                $rated = 0;

                foreach($judges as $judge){
                $rating = FinalRate::where('judgesCode', $judge->accessCode)
                ->where('contestantID', $con->contestantID)
                ->select('beauty', 'poise', 'projection')
                ->first();

                if($rating){
                $individualRating = $rating->beauty + $rating->poise + $rating->projection;
                $totalRating[] = $individualRating;
                $sumOfRatings += $individualRating;
                $rated ++;
                }else{
                $totalRating[] = 0;
                }
                }

                $contestantDetails->totalRate = $totalRating;


                if($sumOfRatings > 0){
                $contestantDetails->total = round(($sumOfRatings / $rated), 2);
                }else{
                $contestantDetails->total = 0;
                }

                return $contestantDetails;
                });

                $sortedContestants = $contestants->sortByDesc('total');

                $rank = 1;
                $prevTotal = null;
                $rankedContestants = $sortedContestants->map(function ($con) use (&$rank, &$prevTotal) {
                    if ($con['total'] !== null) {
                        if ($prevTotal !== null && $con['total'] < $prevTotal) {
                            $rank++;
                        }
                        $con['rank'] = $rank;
                        $prevTotal = $con['total'];
                    } else {
                        $con['rank'] = '?';
                    }
                    return $con;
                });
        
                $response = [
                    'contestants' => $rankedContestants->values(),
                    'judges' => $judges,
                ];

            return response()->json($response);
    }

    public function store(Request $request){
        $data = $request->input('data', []); 

        $preliminaries = [];

        foreach ($data as $item) {
            $preliminaries[] = [
                'contestantID' => $item['contestantID'],
                'judgesCode' => session('access_code'),
                'eventID' => session('event_id'),
                'poise' => $item['poise'],
                'projection' => $item['projection'],
                'beauty' => $item['beauty'],
            ];
        }

        FinalRate::insert($preliminaries);
        return response()->json($request->data);

        // return response()->json('Records inserted successfully');
    }

    public function update(Request $request){

        $accessCode = session('access_code');
 
        $data = $request->input('data', []);

        $gownIdsToUpdate = [];
    
        foreach ($data as $item) {
            $contestantID = $item['contestantID'];
            $beauty = $item['beauty'];
            $poise = $item['poise'];
            $projection = $item['projection'];
    
            FinalRate::where('judgesCode', $accessCode)
                ->where('contestantID', $contestantID)
                ->update([
                    'beauty' => $beauty,
                    'poise' => $poise,
                    'projection' => $projection,
                ]);
            $gownIdsToUpdate[] = $contestantID;
        }

        return response()->json( $request->data);

    }
}
