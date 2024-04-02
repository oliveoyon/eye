<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel File</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <style>
        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 3px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination span {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 3px;
            color: #999;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Patient List</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Age</th>
                                        <th>Action</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->student_name }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>{{ $student->age }}</td>
                                        <td><a href="{{ route('details', ['id' => $student->id]) }}">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
