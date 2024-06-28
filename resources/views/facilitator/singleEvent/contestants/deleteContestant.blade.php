<!-- Button trigger modal -->

<button type="button" class="btn btn-outline-danger btn btn-sm mx-2" data-bs-toggle="modal"
    data-bs-target="#deleteContestant{{ $contestant->id }}">
    <i class="fa fa-trash"></i>
</button>

<div class="modal fade" id="deleteContestant{{ $contestant->id }}" tabindex="-1" aria-labelledby="deleteContestantLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteContestantLabel">{{$contestant->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST"
                action="{{ route('contestant.delete', [
                    'contestant' => $contestant->id,
                    'event' => $event->id,
                ]) }}" class="deleteContestant" id="deleteContestant{{$contestant->id}}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <input type="hidden" value="{{$contestant->photo}}" name="contestantPhoto">
                    <p>Are you sure to delete this contestant ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn btn-sm" type="submit" >
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span>Delete</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
