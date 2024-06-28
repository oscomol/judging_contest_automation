<?php

namespace App\Http\Controllers;

use App\Models\Semi;
use Illuminate\Http\Request;

class SemJudgeCtrl extends Controller
{
    public function store(Request $request){

        $data = $request->input('data', []); 

            $preliminaries = [];

            foreach ($data as $item) {
                $preliminaries[] = [
                    'contestantID' => $item['contestantID'],
                    'judgesCode' => session('access_code'),
                    'eventID' => session('event_id'),
                    'beauty' => $item['beauty'],
                    'poise' => $item['poise'],
                    'projection' => $item['projection'],
                ];
            }

            Semi::insert($preliminaries);
            return response()->json($data);

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
    
            Semi::where('judgesCode', $accessCode)
                ->where('contestantID', $contestantID)
                ->update([
                    'beauty' => $beauty,
                    'poise' => $poise,
                    'projection' => $projection,
                ]);
            $gownIdsToUpdate[] = $contestantID;
        }

        return response()->json('Records updated successfully');
     }
}
