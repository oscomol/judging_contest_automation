<!-- Button trigger modal -->

<button type="button" class="btn btn-outline-success btn btn-sm" data-bs-toggle="modal"
    data-bs-target="#viewContestant{{ $contestant->id }}">
    <i class="fa fa-eye"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="viewContestant{{ $contestant->id }}" tabindex="-1" aria-labelledby="viewContestantLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewContestantLabel">Contestant number {{ $contestant->contestantNum }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">


                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="rounded p-2" id="photoCont">
                            <img src="https://res.cloudinary.com/dl5lteg8a/image/upload/v1719283241/{{$contestant->photo}}" class="rounded" id="file-preview" width="100%" height="100%"
                                class="rounded">
                        </div>
                    </div>
                    <div class="col-6 mb-3 d-flex align-items-end text-wrap">
                        <p style="font-size: 15px; text-align: justify;">
                            {{ $contestant->advocacy }}
                        </p>
                    </div>
                </div>




                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>
                                {{ $contestant->name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Address</th>
                            <td>
                                {{ $contestant->address }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Age</th>
                            <td>
                                {{ $contestant->age }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Chest</th>
                            <td>
                                {{ $contestant->chest }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Waist</th>
                            <td>
                                {{ $contestant->waist }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Height</th>
                            <td>
                                {{ $contestant->height }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Weight</th>
                            <td>
                                {{ $contestant->weight }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Hips</th>
                            <td>
                                {{ $contestant->hips }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>

</div>
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

    .table tr,
    .table th {
        font-size: 14px;
    }
</style>
