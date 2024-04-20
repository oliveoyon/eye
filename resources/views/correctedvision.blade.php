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
                        <!-- Table to display corrected vision data -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Corrected Vision (R)</th>
                                    <th>Before 6 Months</th>
                                    <th>After 6 Months</th>
                                    <th>Variation (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $result)
                                    <tr>
                                        <td>
                                            @if(isset(config('research.visioninfo')[$result->corrected_vision_l]))
                                                {{ config('research.visioninfo')[$result->corrected_vision_l] }}
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>{{ $result->before_six_months }}</td>
                                        <td>{{ $result->after_six_months }}</td>
                                        <td>{{ number_format($result->percentage, 2) }}%</td>
                                    </tr>
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
