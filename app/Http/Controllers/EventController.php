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
     }

     public function dashboard()
     {
         $currentYear = date('Y'); // Get current year
         
         // Array of month names with their respective numbers
         $monthNames = [
             '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
             '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
             '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
         ];
         
         // Initialize an array to store counts for each month with month names
         $monthsEventCounts = [];
         
         // Loop through each month of the current year
         for ($month = 1; $month <= 12; $month++) {
             // Format month to two digits (01 for January, 02 for February, etc.)
             $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
             
             // Concatenate year and month (e.g., 2024-01 for January 2024)
             $monthsToday = $currentYear . '-' . $formattedMonth;
             
             // Get count of events for the current month
             $monthsEventCount = Event::where('preliminaryDate', 'LIKE', $monthsToday . '%')->count();
             
             // Use month name instead of formatted month number as key
             $monthName = $monthNames[$formattedMonth];
             
             // Store the count in the array with the month as key
             $monthsEventCounts[$formattedMonth] = [
                 'monthName' => $monthName,
                 'count' => $monthsEventCount
             ];
         }
         
         // Additional counts
         $ongoingCount = Event::where('isDone', 1)->count();
         
         // Fetch other data as needed
         $data = [
             'recentEvent' => Event::latest()->take(5)->get(),
             'eventCount' => Event::count(),
             'adminCount' => Administrator::count(),
             'monthsEventCounts' => array_values($monthsEventCounts), // Array of event counts per month with month names, sorted by month number
             'ongoingCount' => $ongoingCount
         ];
         
         return response()->json($data);
     }     
}
