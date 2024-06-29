<div class="float-end">
    <button type="button" class="btn btn-primary btn btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addContestant">
        <li class="fa fa-plus"></li>
    </button>
</div>



<form method="post" action="{{ route('contestant.create') }}" enctype="multipart/form-data" class="submitContestant">
    @csrf
    @method('post')

    <div class="modal fade" id="addContestant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contestant registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="rounded" id="photoCont">

                                    <div class="d-none" id="photoHolder">
                                        <img src="#" alt="Preview Uploaded Image" id="file-preview"
                                            width="100%" height="80%" class="rounded">
                                        <div class="w-100 p-1 mt-1 rounded bg-primary">
                                            <center>
                                                <label for="photo" style="font-size: 14px; color: white;">
                                                    Change photo
                                                </label>
                                            </center>
                                        </div>
                                    </div>

                                    <label for="photo" id="photoLabel">
                                        <li class="fa fa-user-plus" style="color: lightgray; font-size: 50px;"></li>
                                    </label>

                                    <input type="file" accept=".jpg, .jpeg, .png" id="photo" class="d-none addPhoto" name="photo" required>

                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="rounded" id="advocacyCont">
                                    <div class="mb-3">
                                        <textarea class="form-control" id="name" placeholder="Enter advocacy" name="advocacy" autofocus required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contestantNum" class="form-label">Contestant number</label>
                            <input type="number" class="form-control" id="contestantNum"
                                placeholder="Enter number here" name="contestantNum" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Contestant Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name here"
                                name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter address here"
                                name="address" required>
                        </div>

                        <div class="d-flex gap-2">
                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" placeholder="Enter age here"
                                    name="age" required>
                            </div>

                            <div class="mb-3">
                                <label for="chest" class="form-label">Bust (cm)</label>
                                <input type="number" class="form-control" id="chest"
                                    placeholder="Enter chest" name="chest" required>
                            </div>

                            <div class="mb-3">
                                <label for="waist" class="form-label">Waist (cm)</label>
                                <input type="number" class="form-control" id="waist"
                                    placeholder="Enter waist" name="waist" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <div class="mb-3">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" class="form-control" id="height"
                                    placeholder="Enter height" name="height" required>
                            </div>

                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input type="number" class="form-control" id="weight"
                                    placeholder="Enter weight" name="weight" required>
                            </div>

                            <div class="mb-3">
                                <label for="hips" class="form-label">Hips (cm)</label>
                                <input type="number" class="form-control" id="hips"
                                    placeholder="Enter hips" name="hips" required>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">
                    </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary btn btn-sm" type="submit" >
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span>Submit</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</form>

<style>
    #advocacyCont,
    #photoCont {
        height: 170px;
    }

    #photoCont {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid lightgray;
        padding-bottom: 5px;
    }

    textarea {
        height: 170px;
    }

    .form-label {
        font-size: 15px;
    }

    .form-control {
        font-size: 14px;
    }
</style>
