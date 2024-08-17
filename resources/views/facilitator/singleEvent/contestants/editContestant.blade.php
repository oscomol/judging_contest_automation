<!-- Button trigger modal -->

<button type="button" class="btn btn-outline-primary btn btn-sm" data-bs-toggle="modal"
    data-bs-target="#editContestant{{ $contestant->id }}">
    <i class="fa fa-edit"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="editContestant{{ $contestant->id }}" tabindex="-1" aria-labelledby="editContestantLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContestantLabel"> Edit contestant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post"
                action="{{ route('contestant.update', [
                    'contestantID' => $contestant->id,
                ]) }}"
                enctype="multipart/form-data" class="editContestant"
                id="editCont{{$contestant->id}}">
                @csrf
                @method('put')
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="rounded f-flex flex-column p-2" id="photoCont">

                                <img src="/contestant/image/{{ $contestant->photo }}" alt="{{$contestant->photo}}"
                                id="file-preview-{{$contestant->id}}" width="100%" height="80%" class="rounded">

                                <div class="w-100 p-1 mt-1 rounded bg-primary">
                                    <center>
                                        <label for="photo-edit-{{$contestant->id}}" style="font-size: 14px; color: white;">
                                            Change photo
                                        </label>

                                        <input type="file" accept=".jpg, .jpeg, .png" class="photo-picker" style="display: none;"
                                        id="photo-edit-{{$contestant->id}}" name="photo" imgID="{{$contestant->id}}">

                                    </center>
                                </div>


                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="rounded" id="advocacyCont">
                                <div class="mb-3">
                                    <textarea class="form-control" id="name-{{$contestant->id}}" placeholder="Enter advocacy" name="advocacy" autofocus required>{{ $contestant->advocacy }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contestantNum-{{$contestant->id}}" class="form-label">Contestant number</label>
                        <input type="number" class="form-control" id="contestantNum-{{$contestant->id}}" placeholder="Enter number here"
                            name="contestantNum" value={{ $contestant->contestantNum }} required>
                    </div>

                    <div class="mb-3">
                        <label for="name-{{$contestant->id}}" class="form-label">Contestant Name</label>
                        <input type="text" class="form-control" id="name-{{$contestant->id}}" placeholder="Enter name here"
                            name="name" value={{ $contestant->name }} required>
                    </div>

                    <div class="mb-3">
                        <label for="address-{{$contestant->id}}" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address-{{$contestant->id}}" placeholder="Enter address here"
                            name="address" value={{ $contestant->address }} required>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="mb-3">
                            <label for="age-{{$contestant->id}}" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age-{{$contestant->id}}" placeholder="Enter age here"
                                name="age" value={{ $contestant->age }} required>
                        </div>

                        <div class="mb-3">
                            <label for="ches-{{$contestant->id}}t" class="form-label">Bust (ft)</label>
                            <input type="text" class="form-control numBustEdit" id="chest-{{$contestant->id}}"
                                placeholder="Enter chest measurement here" name="chest" value={{ $contestant->chest }}
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="waist-{{$contestant->id}}" class="form-label">Waist (ft)</label>
                            <input type="text" class="form-control numWaistEdit" id="waist-{{$contestant->id}}"
                                placeholder="Enter waist measurement here" name="waist"
                                value={{ $contestant->waist }} required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="mb-3">
                            <label for="height-{{$contestant->id}}" class="form-label">Height (ft)</label>
                            <input type="text" class="form-control numHeightEdit" id="height-{{$contestant->id}}" placeholder="00 cm"
                                name="height" value={{ $contestant->height }} required>
                        </div>

                        <div class="mb-3">
                            <label for="weight-{{$contestant->id}}" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" id="weight-{{$contestant->id}}"
                                placeholder="Enter weight here" name="weight" value={{ $contestant->weight }}
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="hips-{{$contestant->id}}" class="form-label">Hips (ft)</label>
                            <input type="text" class="form-control numHipsEdit" id="hips-{{$contestant->id}}"
                                placeholder="Enter hips measurement here" name="hips"
                                value={{ $contestant->hips }} required>
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn btn-sm" type="submit" class="updateContestant">
                        <span class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        <span class="update">Update</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function(){
    var fields = document.querySelectorAll('.numBustEdit, .numWaistEdit, .numHeightEdit, .numHipsEdit');

    fields.forEach(function(field) {
        field.addEventListener('input', function() {
            var curVal = this.value;
            var sanitizedValue = curVal.replace(/[^0-9']/g, '');
            this.value = sanitizedValue;
        });
    });
});
</script>