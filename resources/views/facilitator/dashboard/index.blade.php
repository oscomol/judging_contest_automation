@extends('layout.layout')

@section('title')
    Events
@endsection

@include('facilitator.dashboard.searchInput')

@section('searchBar')
    <form action="/jca/events/search" method="GET">
        @csrf
        @method('GET')
        <div class="input-group mb-3 d-none d-sm-flex" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" name="search"
                aria-describedby="button-addon2">
            <button class="btn btn-primary" type="submit" id="button-addon2">
                <li class="fa fa-search"></li>
            </button>
        </div>
    </form>


    <button type="button" class="btn btn-outline-dark border-0 mb-3 d-sm-none" data-bs-toggle="modal"
        data-bs-target="#searchEvent">
        <li class="fa fa-search"></li>
    </button>

    <div class="modal fade" id="searchEvent" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventLabel">Add a new event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('event.create') }}">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        Search events here
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="rounded-3">
        @if (session('loggedIn'))
            <div class="alert alert-success" role="alert">
                {{ session('loggedIn') }}
            </div>
        @endif

        @if (session('eventDeleted'))
            <div class="alert alert-success" role="alert">
                {{ session('eventDeleted') }}
            </div>
        @endif
        @if (session('eventUpdated'))
            <div class="alert alert-success" role="alert">
                {{ session('eventUpdated') }}
            </div>
        @endif
    </div>

    <div class="card w-100">
        <div class="card-body px-3 pt-3">
            <h5 class="card-title">Event list
                <span class="float-end">
                    @include('facilitator.dashboard.addEvent')
                </span>
            </h5>
            @if ($events->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Location</th>
                            <th class="d-none d-md-table-cell">Preliminary (Date)</th>
                            <th class="d-none d-lg-table-cell">Preliminary (Time)</th>
                            <th class="d-none d-md-table-cell">Semi/final (Date)</th>
                            <th class="d-none d-lg-table-cell">Semi/final (Time)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->location }}</td>
                                <td class="d-none d-md-table-cell">{{ $event->preliminaryDate }}</td>
                                <td class="d-none d-lg-table-cell">{{ $event->preliminaryStartTime }}</td>
                                <td class="d-none d-md-table-cell">{{ $event->finalDate }}</td>
                                <td class="d-none d-lg-table-cell">{{ $event->finalStartTime }}</td>
                                <td class="d-flex gap-2">
                                    @include('facilitator.dashboard.editEvent')

                                    <div>
                                        <a href="{{ route('eventShow.index', [
                                            'event' => $event->id,
                                        ]) }}"
                                            class="btn btn-outline-success btn btn-sm"><i class="fa fa-eye"></i></a>
                                    </div>
                                    <!-- Button trigger modal -->
                                    @include('facilitator.dashboard.deleteEvent')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <div class="w-100 d-flex flex-column align-items-center mt-4 gap-2">
                        <li class="fa fa-calendar" style="font-size: 80px; font-weight: bold; color: gray;"></li>
                        <h5>No events added</h5>
                    </div>
            @endif
        </div>
    </div>
    </table>
    {{ $events->links() }}
    </div>
@endsection



@section('mainScript')
    <script>
        $(document).ready(function() {
           
            $('#eventSubmit').submit(function(event) {
                $('#submitEvent').prop('disabled', true);
                $("#submit").text("Submitting...")
                $('#submitEvent').find('.spinner-border').removeClass('d-none');
            });
            $('#updateEventForm').submit(function(event) {
                $('#updateEvent').prop('disabled', true);
                $("#update").text("Updating...")
                $('#updateEvent').find('.spinner-border').removeClass('d-none');
            });
            $('#deleteEventForm').submit(function(event) {
                $('#deleteEvent').prop('disabled', true);
                $("#delete").text("Deleting...")
                $('#deleteEvent').find('.spinner-border').removeClass('d-none');
            });
        });
    </script>
@endsection


<style>
    .form-label {
        font-size: 15px;
    }

    .form-control {
        font-size: 14px;
    }
</style>
