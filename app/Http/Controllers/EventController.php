<?php

namespace App\Http\Controllers;
use App\Models\Administrator;
use App\Models\Event;
use App\Models\Contestant;
use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{

    public function judgeIndex(Request $request) {

        $events = Event::all()->where('id', $request->event);
        $contestants = Contestant::all()->where('eventID', $request->event);
        $judges = Judge::all()->where('eventID', $request->event);
    }

    public function index() {
        if(!session('username')){
            return redirect(route('admin.login'));
        }else{
        return view('facilitator.dashboard.index',[
            'events' =>Event::orderBy('created_at', 'DESC')->paginate(7)
        ]);
    }
     }

     public function search(Request $request)
     {
         $searchQuery = $request->input('search'); 
         $events = Event::whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($searchQuery) . '%'])
         ->orWhereRaw('LOWER(location) LIKE ?', ['%' . strtolower($searchQuery) . '%'])
         ->orderBy('created_at', 'DESC')
         ->paginate(7);

         return view('facilitator.dashboard.eventSearch', [
             'events' => $events,
             'searchQuery' => $searchQuery
         ]);
     }
     


    public function store(Request $request) {

        $data = $request->validate([
            'title' => 'required',
            'preliminaryDate' => 'required',
            'preliminaryStartTime' => 'required',
            'finalDate' => 'required',
            'finalStartTime' => 'required',
            'location' => 'required',

        ]);

        $newData = Event::create($data);
        return redirect()->route('eventShow.index', [
            'event' => $newData->id
        ])->with('eventCreated', "Event created succesfully!");
     }

     public function destroy(Request $request, Event $event) {
        $event->delete();

        return redirect()->route('event.index')->with('eventDeleted', 'Event deleted succesfully!');

     }

     public function update(Request $request, Event $event) {

        $event = Event::findOrFail($request -> eventID);

        $event->title = $request->title;
        $event->location = $request->location;
        $event->preliminaryDate = $request->preliminaryDate;
        $event->preliminaryStartTime = $request->preliminaryStartTime;
        $event->finalDate = $request->finalDate;
        $event->finalStartTime = $request->finalStartTime;

        $event->save();

        return redirect()->route('event.index')->with('eventUpdated', 'Event updated succesfully!');

     }
     public function show(Request $request) {

        $contestants = Contestant::where('eventID', $request->event)
        ->orderBy('contestantNum')
        ->paginate(5);


        $events = Event::all()->where('id', $request->event);
        return view('facilitator.singleEvent.dashboard.index', [
            'event' => $events->first(),
            'contestants' => $contestants
        ]);
        // $contestants = Contestant::all()->where('eventID', $request->event);
        // $preliminaryJudges = Judge::where([
        //     ['eventID', '=', $request->event],
        //     ['category', '=', 'Preliminary']
        // ])->get();

        // $finalJudges = Judge::where([
        //     ['eventID', '=', $request->event],
        //     ['category', '=', 'Final']
        // ])->get();

        // if(!session('username')){
        //     return redirect(route('admin.login'));
        // }else{
        //     if($events->count() > 0){
        //         return view('facilitator.singleEvent.index', [
        //             'event' => $events->first(),
        //             'contestants' => $contestants,
        //             'preliminaryJudges' => $preliminaryJudges,
        //             'finalJudges' => $finalJudges
        //         ]);
        //     }else{
        //         return redirect(route('event.index'));
        //     }
        // }
     }

     public function dashboard()
     {

        $currentMonth = date('m');
        $currentYear = date('Y'); 
    
        $monthsToday = $currentYear . '-' . $currentMonth;

        $monthsEventCount = Event::where('preliminaryDate', 'LIKE', $monthsToday . '%')->count();
        $ongoingCount = Event::where('isDone', 1)->count();

         $data = [
             'recentEvent' => Event::latest()->take(5)->get(),
             'eventCount' => Event::count(),
             'adminCount' => Administrator::count(),
             'monthsEventCount' => $monthsEventCount,
             'ongoingCount' => $ongoingCount
         ];
     
         return response()->json($data);
     }
     
}
