<?php

namespace App\Http\Controllers;
use App\Models\Contestant;
use App\Models\Event;
use App\Models\FinalRate;
use App\Models\Gown;
use App\Models\Judge;
use App\Models\Preliminary;
use App\Models\Semi;
use App\Models\SemisContetant;
use App\Models\Swimwear;
use Illuminate\Http\Request;

class SemifinalCtrl extends Controller
{
    public function indexJudges(Request $request) {
        $id = session('event_id');
        $accessCode = session('access_code');
    
        // Fetch contestants for the specified event and category
        $contestants = SemisContetant::where('eventID', $id)
            ->where('category', 'semi')
            ->get();
    
        // Prepare a list of contestant IDs for efficient querying
        $contestantIds = $contestants->pluck('contestantID')->toArray();
    
        // Fetch all semi-final scores for these contestants using access code
        $semiScores = Semi::whereIn('contestantID', $contestantIds)
            ->where('judgesCode', $accessCode)
            ->get();
    
        // Prepare a mapping of contestant ID to their scores for quick lookup
        $scoresByContestantId = $semiScores->keyBy('contestantID');
    
        // Calculate totals and assign ranks to contestants
        $contestantsWithRate = $contestants->map(function($con) use ($scoresByContestantId) {
            $contestant = Contestant::findOrFail($con->contestantID);
    
            // Initialize scores to 0 if no scores are found
            $semiScore = $scoresByContestantId[$con->contestantID] ?? null;
            $beauty = $semiScore ? $semiScore->beauty : 0;
            $poise = $semiScore ? $semiScore->poise : 0;
            $projection = $semiScore ? $semiScore->projection : 0;
    
            // Calculate total score
            $total = $beauty + $poise + $projection;
            
            // Assign scores to contestant object
            $contestant->beauty = $beauty;
            $contestant->poise = $poise;
            $contestant->projection = $projection;
            $contestant->total = $total;
    
            return $contestant;
        });

        $contestantsWithRate = $contestantsWithRate->sortByDesc('total');

        $rank = 1;
        $prevTotal = null;
        $contestantsWithRate = $contestantsWithRate->map(function ($con) use (&$rank, &$prevTotal) {
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
    
    
        // Sort contestants by rank ascending
        $contestantsWithRate = $contestantsWithRate->sortBy('contestantNum');
    
        // Determine unique ranks
        $uniqueRanks = $contestantsWithRate->filter(function($con){
            return $con->total > 75;
        });
    
        // Pass data to view
        return view('jcaJudges.pages.final.semifinal', [
            'semiContestant' => $contestantsWithRate,
            'ranks' => $uniqueRanks->count()
        ]);
    }
    
    public function index(Request $request) {

        $eventId = $request->event;

        $event = Event::findOrFail($eventId);
        return view('facilitator.singleEvent.ratings.final.semi', [
            'event' => $event]);
    }

    public function getIndex(Request $request)
    {
        $eventId = $request->event;
        $judges = Judge::where('eventID', $eventId)
                        ->where('category', 'Final')
                        ->get();
    
        $semis = SemisContetant::where('eventID', $eventId)
                                ->where('category', 'semi')
                                ->get();
    
        $semisContestants = $semis->map(function ($con) use ($eventId, $judges) {
            $contestant = Contestant::where('id', $con->contestantID)->first();
    
            $class = SemisContetant::where('contestantID', $con->contestantID)
                                    ->where('category', 'final')
                                    ->get();
    
            $totalRating = [];
            $sumOfRatings = 0;
            $rated = 0;
    
            foreach ($judges as $judge) {
                $rating = Semi::where('judgesCode', $judge->accessCode)
                                ->where('contestantID', $con->contestantID)
                                ->select('beauty', 'poise', 'projection')
                                ->first();
    
                if ($rating) {
                    $individualRating = $rating->beauty + $rating->poise + $rating->projection;
                    $totalRating[] = $individualRating;
                    $sumOfRatings += $individualRating;
                    $rated++;
                } else {
                    $totalRating[] = 0;
                }
            }
    
            $contestant->totalRating = $totalRating;
    
            if ($sumOfRatings > 0) {
                $contestant->total = round(($sumOfRatings / $rated), 2);
            } else {
                $contestant->total = 0;
            }
    
            if ($class->isNotEmpty()) {
                $contestant->class = "bg-none";
            } else {
                $contestant->class = "";
            }
    
            return $contestant->toArray(); // Ensure $contestant is converted to an array
        });
    
        $sortedContestants = $semisContestants->sortByDesc('total')->values();
        $rank = 1;
        $prevTotal = null;
        $sortedContestants = $sortedContestants->map(function ($con) use (&$rank, &$prevTotal) {
            if ($con['total'] !== null && $con['total'] > 0) {
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

        $sortedContestants = $sortedContestants->sortBy('contestantNum')->values();
    
        $data = [
            'contestants' => $sortedContestants,
            'judges' => $judges
        ];
    
        return response()->json($data);
    }

}
