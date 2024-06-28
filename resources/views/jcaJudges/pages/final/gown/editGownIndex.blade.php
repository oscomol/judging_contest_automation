@extends('layout.judgesLayout')


@section('judgesNavs')
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a  href="{{ route('final.index') }}"  class="sidebar-link">
                <i class="fa fa-tachometer"></i>
                <span>Gown</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('semifinal.index') }}" class="sidebar-link">
                <i class="fa fa-calendar"></i>
                <span>Semifinal</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('finalJudge.index') }}" class="sidebar-link">
                <i class="fa fa-calendar"></i>
                <span>Final</span>
            </a>
        </li>

    </ul>
@endsection


@section('judgesCont')
   <div id="result">
    <form action="{{ route('gownScore') }}" method="POST" id="addSwimwear">

        <div class="p-0">
            @if ($isRecorded)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rating sheet
                        <span class="float-end">
                            @if ($isRecorded)
                            <button type="submit" id="updateBtn" class="btn btn-primary btn btn-sm">Update</button>
                            @endif
                            <button type="submit" id="swimwearSubmitButton" class="btn btn-primary btn btn-sm" disabled>Submit</button>
                        </span>
                    </h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Suitability (50%)</th>
                                <th scope="col">Poise and Projection (50%)</th>
                                <th scope="col">Total</th>
                                @if ($isRecorded)
                                    <th scope="col">Rank</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        @if ($contestant->suitability)
                                            {{ $contestant->suitability }}
                                        @else
                                            <input type="number" class="form-control w-75 suitability"
                                                placeholder="Composure" min="1" max="50" name="suitability">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 swimwearProjection"
                                                placeholder="Projection" min="1" max="50"
                                                name="swimwearProjection">
                                        @endif
                                    </td>
                                    <td class="swimwearTotal">
                                        @if ($contestant->projection && $contestant->suitability)
                                            {{ $contestant->projection + $contestant->suitability }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($isRecorded)
                                        <td>
                                            {{ $contestant->rank }}
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </form>
   </div>

   <div id="update" class="d-none">
        @include('jcaJudges.pages.final.gown.editGownIndex')
   </div>


@endsection