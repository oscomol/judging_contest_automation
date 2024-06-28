<div id="result">
    <form action="{{ route('preliminaryUpdate') }}" method="POST" id="editSwimwear">
        @csrf <!-- Add CSRF token field for Laravel forms -->
        @method('POST')
        <div class="p-0">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rating sheet
                        <span class="float-end">
                            <button type="submit" id="swimwearEditButton" class="btn btn-primary btn btn-sm">Update</button>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>
                                        <span style="visibility: hidden">{{ $contestant->id }}</span>
                                        {{ $contestant->contestantNum }}. {{ $contestant->name }}
                                    </th>
                                    <td>
                                        <input type="number" class="form-control w-75 suitability"
                                            placeholder="Composure" min="1" max="50" name="suitability"
                                            value="{{ $contestant->poise }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control w-75 swimwearProjection"
                                            placeholder="Projection" min="1" max="50" name="swimwearProjection[]"
                                            value="{{ $contestant->projection }}">
                                    </td>
                                    <td class="swimwearTotal">
                                        {{ $contestant->poise + $contestant->projection }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
        // Validate and update totals on input change
        $('input[type="number"]').on('input', function() {
            var value = parseInt($(this).val(), 10);
            if (value < 1) {
                $(this).val(1);
            } else if (value > 50) {
                $(this).val(50);
            }
  
            updateTotals();
        });
  
        // Update totals function
        function updateTotals() {
            $('tbody tr').each(function() {
                var row = $(this);
                var composure = parseInt(row.find('.suitability').val()) || 0;
                var projection = parseInt(row.find('.swimwearProjection').val()) || 0;
                var total = composure + projection;
                row.find('.swimwearTotal').text(total);
            });
  
            // Enable/disable submit button based on total condition
            var isMoreThan75 = true; // Example condition based on your logic
            if (isMoreThan75) {
                $('#swimwearEditButton').prop('disabled', false);
            } else {
                $('#swimwearEditButton').prop('disabled', true);
            }
        }
  
        // Handle form submission via AJAX
        $('#editSwimwear').submit(function(event) {
            event.preventDefault(); 
            const confirmSave = confirm('Are you sure to save ratings ?');
            if(!confirmSave) return;
  
            $('#swimwearEditButton').prop('disabled', true);

                  const rows = $('tbody tr');
                  const rowData = [];
                  var url = $(this).attr("action");
  
                  rows.each(function() {
                      const row = $(this);
                      const suitability = row.find('.suitability');
                      const projectionInput = row.find('.swimwearProjection');
                      const initTotal = row.find('.swimwearTotal').text();
                      let total = 0;
  
                      if (!isNaN(initTotal)) {
                          total = Number(initTotal);
                      }
  
                      const rowObj = {
                          contestantID: row.find('span').text().trim(),
                          poise: suitability.val(),
                          projection: projectionInput.val(),
                          total
                      };
  
                      rowData.push(rowObj);
                  });
  
                  const filteredData = rowData.filter(data => data.poise !== undefined);
                 
                  if(filteredData?.length){
                    sendData(filteredData, url);
                  }
                 });
            });
  
            function sendData(data, url) {
              const formData = {
                  data
              }
                processSend(formData)
  
                function processSend(formData) {
                    $.post(url, formData)
                        .done(function(response) {
                          location.reload();
                        })
                        .fail(function(error) {
                            console.log(error)
                            processSend(formData)
                        });
                }
              }
  </script>
  