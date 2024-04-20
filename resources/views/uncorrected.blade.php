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
                                    <th>Age</th>
                                    @foreach (config('research.visioninfo') as $visionInfo)
                                        <th>{{ $visionInfo }}</th>
                                    @endforeach
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ageGroups as $age => $group)
                                    <tr>
                                        <td>{{ $age }}</td>
                                        @php
                                            $sumtot = 0;
                                        @endphp
                                        @foreach (config('research.visioninfo') as $visionInfoKey => $visionInfo)

                                            @php
                                                $percentage = $totalCount > 0 ? number_format(($group[$visionInfoKey]->count ?? 0) / $totalCount * 100, 2) : 0;
                                                $sumtot+=$percentage;
                                            @endphp
                                            <td>{{ $percentage }}</td>

                                            {{-- <td>{{ $group[$visionInfoKey]->count ?? 0 }}</td> --}}

                                        @endforeach
                                        <td>{{ $sumtot }}%</td>
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
