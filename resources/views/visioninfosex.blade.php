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
                                    <th>Gender</th>
                                    @foreach (config('research.visioninfo') as $visionInfo)
                                        <th>{{ $visionInfo }}</th>
                                    @endforeach
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($genderGroups as $gender => $group)
                                    <tr>
                                        <td>{{ $gender }}</td>
                                        @php
                                            $total = $group->sum('count');
                                        @endphp
                                        @foreach (config('research.visioninfo') as $visionInfoKey => $visionInfo)
                                            <td>{{ $group[$visionInfoKey]->count ?? 0 }}</td>
                                        @endforeach
                                        <td>{{ $total > 0 ? number_format(($total / $totalCount) * 100, 2) : 0 }}%</td>
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
