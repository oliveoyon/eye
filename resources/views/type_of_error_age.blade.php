<!DOCTYPE html>
<html>

<head>
    <title>Upload Excel File</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Uncorrected</div>

                    <div class="card-body">
                        <h1>Type of Error Data by Age</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type of Error</th>
                                    @foreach ($data[0]['age_groups'] as $age)
                                        <th colspan="2">{{ $age }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Type of Error</th>
                                    @foreach ($data[0]['age_groups'] as $age)
                                        <th>Male</th>
                                        <th>Female</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $typeData)
                                    <tr>
                                        <td>{{ $typeData['type'] }}</td>
                                        @foreach ($typeData['data'] as $row)
                                            @foreach ($row['counts'] as $count)
                                                <td>{{ $count }}</td>
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        {{-- <table border="1">
                            <thead>
                                <tr>
                                    <th>Type of Error</th>
                                    @foreach ($data[0]['data'] as $row)
                                        <th colspan="2">{{ $row['sex'] }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    @foreach ($data[0]['data'] as $row)
                                        <th>Count</th>
                                        <th>Percentage</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $typeData)
                                    @foreach ($typeData['age_groups'] as $index => $age)
                                        <tr>
                                            @if ($index === 0)
                                                <td rowspan="{{ count($typeData['age_groups']) }}">{{ $typeData['type'] }}</td>
                                            @endif
                                            <td>{{ $age }}</td>
                                            @foreach ($typeData['data'] as $row)
                                                <td>{{ $row['counts'][$index] }}</td>
                                                <td>{{ number_format(($row['counts'][$index] / array_sum($row['counts'])) * 100, 2) }}%</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>

<!-- Auto-dismiss the alert after a certain time -->
<script>
    $(document).ready(function() {
        // Auto-dismiss alert after 5 seconds
        setTimeout(function() {
            $(".alert").alert('close');
        }, 5000);
    });
</script>

</html>
