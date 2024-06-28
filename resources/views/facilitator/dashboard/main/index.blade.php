@extends('layout.layout')

@section('title')
    Dashboard
@endsection

@include('facilitator.dashboard.searchInput')

@section('content')
    <div class="d-flex flex-column align-items-center gap-2" id="loadingDoc">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"></div>
        <h5>Setting up dashboard. Please wait!</h5>
    </div>

    <div id="eventMainContent" class="d-none">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4"> <!-- Adjusted column classes -->
                <div class="p-3 rounded bg-primary bg-gradient d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-light fw-bold allEventCount">0</h3>
                        <p class="text-light">All events</p>
                    </div>
                    <div>
                        <i class="fa fa-envelope" style="font-size: 60px; color: white; font-weight: bold;"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4"> <!-- Adjusted column classes -->
                <div class="p-3 rounded bg-success bg-gradient d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-light fw-bold adminCount">0</h3>
                        <p class="text-light">Administrator</p>
                    </div>
                    <div>
                        <i class="fa fa-user" style="font-size: 60px; color: white; font-weight: bold;"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4"> <!-- Adjusted column classes -->
                <div class="p-3 rounded bg-warning bg-gradient d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-light fw-bold monthsEventCount"></h3>
                        <p class="text-light">January, 2024</p>
                    </div>
                    <div>
                        <i class="fa fa-calendar" style="font-size: 60px; color: white; font-weight: bold;"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4"> <!-- Adjusted column classes -->
                <div class="p-3 rounded bg-danger bg-gradient d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-light fw-bold ongoingEventCount">65</h3>
                        <p class="text-light">Ongoing</p>
                    </div>
                    <div>
                        <i class="fa fa-upload" style="font-size: 60px; color: white; font-weight: bold;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 d-flex chartCont">
            <div class="card cartCont">
                <div class="card-body px-3 pt-3">
                    <h5 class="card-title">Events by month</h5>
                    <div id="chart"></div>
                </div>
            </div>

            <div class="card cartCont">
                <div class="card-body px-3 pt-3">
                    <h5 class="card-title">Miss Gay 2020</h5>
                    <div id="pie"></div>
                </div>
            </div>
        </div>

        <div class="card w-100 my-4">
            <div class="card-body px-3 pt-3">
                <h5 class="card-title">Recently added events</h5>

                <table class="d-none" id="eventDashboard">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" class="d-none d-md-table-cell">Location</th>
                            <th scope="col">Preliminary</th>
                            <th scope="col">Cronation</th>
                        </tr>
                    </thead>
                    <tbody id="recentEventTable"></tbody>
                </table>

                <div class="w-100 d-flex flex-column align-items-center mt-4 gap-2" id="noEventDash">
                    <li class="fa fa-calendar" style="font-size: 80px; font-weight: bold; color: gray;"></li>
                    <h5>No events added</h5>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('mainScript')


@section('mainScript')
    <script type="module">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/jca/all/dashboard',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $("#loadingDoc").removeClass().addClass('d-none');
                    $("#eventMainContent").removeClass().addClass('container-fluid');
                    const {
                        recentEvent,
                        eventCount,
                        adminCount,
                        monthsEventCount,
                        ongoingCount
                    } = data;
                    $(".allEventCount").text(eventCount);
                    $(".adminCount").text(adminCount);
                    $(".monthsEventCount").text(monthsEventCount);
                    $(".ongoingEventCount").text(ongoingCount);
                    let recentEventTable = '';

                    if (recentEvent?.length) {
                        $('#eventDashboard').removeClass().addClass('table table-bordered');
                        $('#noEventDash').removeClass().addClass('d-none');

                        for (let x = 0; x < recentEvent.length; x++) {
                            const event = recentEvent[x];
                            recentEventTable += `
                            <tr>
                                <th scope="row">${event.title}</th>
                                <td class="d-none d-md-table-cell">${event.location}</td>
                                <td>${event.preliminaryDate}</td>
                                <td>${event.finalDate}</td>
                            </tr>
                        `;
                        }
                        $("#recentEventTable").html(recentEventTable);
                    }
                    displayChart()
                }
            });
        });

        function displayChart() {
            var options1 = {
                chart: {
                    type: 'bar'
                },
                series: [{
                    name: 'sales',
                    data: [30, 40, 45, 50, 49, 60, 70, 91, 125, 23, 33]
                }],
                xaxis: {
                    categories: ['Jan', "Feb", "Mar", 'Apr', "May", "Jun", "Jul", "Aug", "Sep", "Oct", 'Nov', 'Dec']
                }
            };

            var options2 = {
                chart: {
                    type: 'pie',
                    height: 400
                },
                series: [44, 55, 13, 43, 22, 44, 55, 13, 43, 22, 44, 55, 13, 43, 22],
                labels: ['Apple', 'Mango', 'Banana', 'Orange', 'Grapes', 'Apple', 'Mango', 'Banana', 'Orange', 'Grapes',
                    'Apple', 'Mango', 'Banana', 'Orange', 'Grapes'
                ],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#chart"), options1);
            var chart2 = new ApexCharts(document.querySelector("#pie"), options2);

            chart1.render();
            chart2.render();
        }
    </script>
@endsection

@endsection

<style>
.chartCont {
    gap: 25px;
}

.cartCont {
    flex: 1;
}

@media (max-width: 900px) {
    .chartCont {
        flex-direction: column;
    }
}
</style>
