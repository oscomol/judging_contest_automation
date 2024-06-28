<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JudgeController extends Controller
{

    public function judgesDashboard(Request $request){

        $judges = Judge::where('eventID', $request->event)->get();

        $data = [
            "judges" =>$judges
        ];
        return response()->json($data);
    }
    public function index(Request $request){
        $event = $request->event;
        $accessCode = $request->accessCode;
        $category = $request->category;
        $eventValue = substr($event, strpos($event, '=') + 1);
        $accessCodeValue = substr($accessCode, strpos($accessCode, '=') + 1);
        $categoryValue = substr($category, strpos($category, '=') + 1);

        return view('jcaJudges.index',[
            'accessCode' => $accessCodeValue,
            'event' => $eventValue,
            'category' => $categoryValue
        ]);
    }

    public function store(Request $request) {

        $data = Judge::create([
            'name' => $request->name,
            'judgeNum' => $request->judgeNum,
            'eventID'=> $request->eventID,
            'accessCode' => Str::random(5),
            'category' => $request->category
        ]);

        return redirect(route('eventShow.show', [
            'event' => $request->eventID
        ]));

     }

     public function destroy(Request $request){
        Judge::where('id', $request->judge)->delete();

        return redirect(route('eventShow.show', [
            'event' => $request->event
        ]));
     }

     public function update(Request $request)
     {

         $judge = Judge::findOrFail($request -> judge);


         $judge->name = $request->name;
         $judge->judgeNum = $request->judgeNum;
         $judge->accessCode = $request->accessCode;

         $judge->save();

         return redirect(route('eventShow.show', [
            'event' => $request->event
        ]));
     }

     public function adminIndex(Request $request){
        $events = Event::all()->where('id', $request->event);

        $preliminaryJudges = Judge::where([
            ['eventID', '=', $request->event],
            ['category', '=', 'Preliminary']
        ])->get();

        $finalJudges = Judge::where([
            ['eventID', '=', $request->event],
            ['category', '=', 'Final']
        ])->get();

        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
            if($events->count() > 0){
                return view('facilitator.singleEvent.index', [
                    'event' => $events->first(),
                    'preliminaryJudges' => $preliminaryJudges,
                    'finalJudges' => $finalJudges
                ]);
            }else{
                return redirect(route('event.index'));
            }
        }
     }
}
