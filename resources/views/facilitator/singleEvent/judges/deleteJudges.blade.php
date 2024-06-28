<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-danger btn btn-sm mx-2" data-bs-toggle="modal"
    data-bs-target="#deleteAdmin-{{ $judge->id }}">
    <li class="fa fa-trash"></li>
</button>

<!-- Modal -->
<div class="modal fade" id="deleteAdmin-{{ $judge->id }}" tabindex="-1" aria-labelledby="deleteAdminLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form
                action="{{ route('judge.delete', [
                    'event' => $event->id,
                    'judge' => $judge->id,
                ]) }}"
                method="POST"
                class="adminDelete">
                @csrf
                @method('delete')
                <div class="modal-body">
                   <p>Are you sure to delete admin {{$judge->name}}</p>
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
