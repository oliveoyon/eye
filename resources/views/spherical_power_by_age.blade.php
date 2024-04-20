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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Age</th>
                                    <th colspan="{{ count($combinedResults) * 2 }}">Spherical Power (Right Eye)</th>
                                </tr>
                                <tr>
                                    @foreach ($combinedResults as $category => $ageData)
                                        <th colspan="2">{{ $category }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($combinedResults as $category => $ageData)
                                    @foreach ($ageData as $age => $data)
                                        <tr>
                                            @if ($loop->first)
                                                <td rowspan="{{ count($ageData) }}">{{ $age }}</td>
                                            @endif
                                            @foreach ($data as $value)
                                                <td>{{ $value['before_six_months'] ?? 0 }}</td>
                                                <td>{{ $value['after_six_months'] ?? 0 }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>



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
