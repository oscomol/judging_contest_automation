@extends('layout.eventLayout')

@section('eventContent')
    <div class="d-flex flex-column align-items-center gap-2" id="loading">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"></div>
        <h5>Getting data. Please wait!</h5>
    </div>

    <div class="d-none" id="result">
        <div class="card-header">
            <h3 class="card-title">Tabulation</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr class="judges">
                        <th></th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr class="totalRow">
                        <th style="width: 240px">Contestant</th>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('mainScript')
    <script type="module">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const eventID = window.location.pathname.split('/')[3];
            $.ajax({
                url: '/getGown/get?event=' + eventID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#loading').removeClass().addClass('d-none');
                    $('#result').removeClass().addClass('card');

                    const contestants = data.contestants;
                    const judges = data.judges;

                    displayJudges(judges);
                    displayResult(contestants);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    // Handle error if needed
                }
            });
        });

        function displayJudges(judges) {
            let judgesHtml = '';
            let totalRow = '';
            for (let i = 0; i < judges.length; i++) {
                const judge = judges[i];
                judgesHtml += `<th>${judge.name}</th>`;
                totalRow += `<th>Total</th>`;
            }
            $('.judges').append(judgesHtml);
            $('.totalRow').append(totalRow);
            $('.totalRow').append('<th>Total</th>');
            $('.totalRow').append('<th>Rank</th>');
        }

        function displayResult(contestants) {
            let contestantsHtml = '';
            for (let x = 0; x < contestants.length; x++) {
                const contestant = contestants[x];
                let totalHtml = '';
                for (let y = 0; y < contestant.total.length; y++) {
                    totalHtml += `<th>${contestant.total[y]}</th>`;
                }
                contestantsHtml += `
                    <tr>
                        <th>${contestant.contestantNum}. ${contestant.name}</th>
                        ${totalHtml}
                        <th>${contestant.totalRate}</th>
                        <th>${contestant.rank}</th>
                    </tr>
                `;
            }
            $('.tbody').append(contestantsHtml);
        }
    </script>
@endsection
