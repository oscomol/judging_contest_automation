<div>
    <button type="button" class="btn btn-outline-danger btn btn-sm"
        data-bs-toggle="modal" data-bs-target="#event{{ $event->id }}"><i
            class="fa fa-trash"></i></button>
</div>


<form
    action="{{ route('event.delete', [
        'event' => $event->id,
    ]) }}"
    method="POST" id="deleteEventForm">
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
                    <button class="btn btn-danger btn btn-sm" type="submit" id="deleteEvent">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span id="delete">Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>