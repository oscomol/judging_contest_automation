<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Contestant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContestantController extends Controller
{
    public function index(Request $request){

        $events = Event::all()->where('id', $request->event);
        $contestants = Contestant::where('eventID', $request->event)->paginate(8);
       
        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
            if($events->count() > 0) {
                return view('facilitator.singleEvent.contestants.index', [
                    'event' => $events->first(),
                    'contestants' => $contestants,
                ]);
            }else{
                return redirect(route('event.index'));
            }
        }
    }

    public function addNew(Request $request){
        $events = Event::all()->where('id', $request->event);

        return view("facilitator.singleEvent.contestants.addContestant", [
            'event' => $events->first(),
        ]);
    }

    public function store(Request $request) {

        try{
        $response = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

        $filename = basename($response);

        $validatedData = $request->validate([
            'name' => 'required',
            'advocacy' => 'required',
            'address' => 'required',
            'contestantNum' => 'required',
            'age' => 'required',
            'chest' => 'required',
            'waist' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'eventID' => 'required',
            'hips' => 'required'
        ]);

        $newData = Contestant::create([
            'name' => $validatedData['name'],
            'photo' => $filename,
            'advocacy' =>$validatedData['advocacy'],
            'contestantNum' => $validatedData['contestantNum'],
            'eventID' => $validatedData['eventID'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'chest' => $validatedData['chest'],
            'waist' => $validatedData['waist'],
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'hips' => $validatedData['hips'],
        ]);

        return redirect(route('contestant.index', [
            'event' => $validatedData['eventID']
        ]));
        }catch(\Exception $e){
            return back()->with('contestantCreateErr',  'Registration failed! Try again with unique contestant no.');
        }
    }

    public function update(Request $request) {

        try{
            $contestant = Contestant::findOrFail($request -> contestantID);
            $file= $request->file('photo');
            if($file){
                $response = cloudinary()->upload( $file->getRealPath())->getSecurePath();

                $filename = basename($response);
            
            $contestant->advocacy = $request->advocacy;
            $contestant->chest = $request->chest;
            $contestant->waist = $request->waist;
            $contestant->height = $request->height;
            $contestant->weight = $request->weight;
            $contestant->hips = $request->hips;
            $contestant->name = $request->name;
            $contestant->photo = $filename;
            $contestant->contestantNum = $request->contestantNum;
            $contestant->eventID = $request->eventID;
            $contestant->address = $request->address;
            }else{
    
            $contestant->advocacy = $request->advocacy;
            $contestant->chest = $request->chest;
            $contestant->waist = $request->waist;
            $contestant->height = $request->height;
            $contestant->weight = $request->weight;
            $contestant->hips = $request->hips;
            $contestant->name = $request->name;
            $contestant->contestantNum = $request->contestantNum;
            $contestant->eventID = $request->eventID;
            $contestant->address = $request->address;
            }
    
            $contestant->save();
    
            return redirect(route('contestant.index', [
                'event' => $request->eventID
            ]));
        }catch(\Exception $e){
            return back()->with('contestantCreateErr',  'Update error! Try again with unique contestant no.');
        }
    }

    public function destroy(Request $request){

        Contestant::where('id', $request->contestant)->delete();

        return redirect(route('contestant.index', [
            'event' => $request->event
        ]));
     }
}
