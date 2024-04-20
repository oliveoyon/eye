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
                    <div class="card-header">Overall Study Participant Data</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Area</th>
                                    <th>Male Students</th>
                                    <th>Female Students</th>
                                    <th>Other Students</th>
                                    <th>Total Students</th>
                                    <th>Male (%)</th>
                                    <th>Female (%)</th>
                                    <th>Other (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentsData as $data)
                                <tr>
                                    <td>{{ config('research.area.' . $data->area) }}</td>
                                    <td>{{ $data->male_students }}</td>
                                    <td>{{ $data->female_students }}</td>
                                    <td>{{ $data->other_students }}</td>
                                    <td>{{ $data->male_students + $data->female_students + $data->other_students }}</td>
                                    <td>{{ number_format(($data->male_students / ($data->male_students + $data->female_students + $data->other_students)) * 100, 2) }}</td>
                                    <td>{{ number_format(($data->female_students / ($data->male_students + $data->female_students + $data->other_students)) * 100, 2) }}</td>
                                    <td>{{ number_format(($data->other_students / ($data->male_students + $data->female_students + $data->other_students)) * 100, 2) }}</td>
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
