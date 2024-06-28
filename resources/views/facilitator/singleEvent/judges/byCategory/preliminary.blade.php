<div class="card w-100 mt-3 mb-3">

    <div class="card-body px-3 pt-3">
        <h3 class="card-title">Preliminary Judges
            <span class="float-end">
                <button type="button" class="btn btn-primary btn btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addJudges">
                    <li class="fa fa-plus"></li>
                </button>
            </span>
        </h3>
       
        @if ($preliminaryJudges->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="d-none d-md-table-cell">Judge number</th>
                    <th>Name</th>
                    <th>Access code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($preliminaryJudges as $judge)
                    <tr id="judgeRow{{ $judge->id }}">
                        <th class="d-none d-md-table-cell">{{ $judge->judgeNum }}</th>
                        <td>{{ $judge->name }}</td>
                        <td>{{ $judge->accessCode }}</td>

                        <td class="d-flex">
                            <div>
                                @include('facilitator.singleEvent.judges.edit')
                            </div>

                            <div>
                                @include('facilitator.singleEvent.judges.deleteJudges')
                            </div>
                            </form>

                            <div class="d-flex">
                                <button 
                                class="btn btn-outline-secondary btn btn-sm eventJudges"
                                id="copyBtn-{{$judge->accessCode}}"
                                    code={{ $judge->accessCode }} category="Preliminary" eventId={{ $event->id }}><i
                                        class="fa fa-clipboard"></i>
                                </button>

                                <button class="d-none" id="copy-{{$judge->accessCode}}">
                                    <i class="fa fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="w-100 d-flex flex-column align-items-center mt-4 gap-2" id="noJudges">
            <li class="fa fa-users" style="font-size: 80px; font-weight: bold; color: gray;"></li>
            <h5>No list to show</h5>
        </div>
        @endif


        <div class="modal fade" id="addJudges" tabindex="-1" aria-labelledby="addJudgesLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addJudgesLabel">Judge number
                            {{ $preliminaryJudges->count() > 0 ? $preliminaryJudges->last()->judgeNum + 1 : 1 }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="post" action="{{ route('judges.create') }}" class="addJudgesForm">
                        @csrf
                        @method('post')
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="name" class="form-label">Judge name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name here"
                                    name="name">
                            </div>

                            <input type="hidden" class="form-control" name="category" value="Preliminary">


                            <input type="hidden" class="form-control" name="judgeNum"
                                value="{{ $preliminaryJudges->count() > 0 ? $preliminaryJudges->last()->judgeNum + 1 : 1 }}">


                            <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn btn-sm" type="submit" id="submitJudge">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span id="submit">Submit</span>
                            </button>
                            <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
</div>