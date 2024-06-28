@extends('layout.layout')

@section('title')
    <span class="d-none d-sm-inline">Search for event</span> <span class="fw-bold">{{$searchQuery}}</span>
@endsection

@include('facilitator.dashboard.searchInput')

@section('content')
    @if ($events->count() > 0)

        <div class="card w-100">
            <div class="card-body px-3 pt-3">
                <h5 class="card-title">Event list
                </h5>
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


                                    <div>
                                        <button type="button" class="btn btn-outline-danger btn btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#event{{ $event->id }}"><i
                                                class="fa fa-trash"></i></button>
                                    </div>


                                    <form
                                        action="{{ route('event.delete', [
                                            'event' => $event->id,
                                        ]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')


                                        <div class="modal fade" id="event{{ $event->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure to delete event <span
                                                                class="text-bold">{{ $event->title }}</span> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Yes</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
        </table>
        {{ $events->links() }}
        </div>
        
    @else
       <div class="mt-5 d-flex flex-column align-items-center gap-1">
            <li class="fa fa-calendar" style="font-size: 50px"></li>
            <h2 class="text-center">Nothing to show here</h2>
       </div>
    @endif


@endsection
