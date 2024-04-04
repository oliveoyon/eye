<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for table styling */

        /* Style table headers */
        .table thead th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        /* Style table rows */
        .table tbody tr {
            border: 1px solid #dee2e6;
        }

        /* Style even rows with a different background color */
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Hover effect on rows */
        .table tbody tr:hover {
            background-color: #e2e6ea;
        }

        .input-cell {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Student Information -->
        <form action="{{ route('formdata') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="eye_examination_id" value="{{ $med_data->id }}">
            <input type="hidden" name="first_table" value="{{ $data->id }}">
            <div class="row">
                <div class="col-md-8">
                    @isset($researchConfig['school_name'][$data['school_cluster']])
                    <h3 style="color: green">{{ $researchConfig['school_name'][$data['school_cluster']] }}</h3>
                    @endisset
                    <h4>Student Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $data->student_name }}</p>
                            <p><strong>Class:</strong> {{ $data->class }}</p>
                            <p>
                                <strong>Fathers Occupation:</strong>
                                @isset($researchConfig['father_occupation'][$data['father_occupation']])
                                {{ $researchConfig['father_occupation'][$data['father_occupation']] }}
                                @endisset
                            </p>


                        </div>
                        <div class="col-md-6">
                            <p><strong>Age:</strong> {{ $data->age }}</p>
                            <p><strong>Sex:</strong> {{ $data->sex == 1 ? 'Male' : 'Female' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>Vision Information</h3>
                    <div class="row">
                        <div class="col-md-12">
                            @if (isset($researchConfig))
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Vision Information (Right)</th>
                                            <th>Vision Information (Left)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select" id="dropdown1" name="vision_information_r">
                                                    <option value="">Select Option</option>
                                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $med_data->vision_information_r == $key ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" id="dropdown1" name="vision_information_l">
                                                    <option value="">Select Option</option>
                                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $med_data->vision_information_l == $key ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p>Research configuration not found.</p>
                            @endif


                        </div>
                    </div>
                </div>
            </div>


            <!-- Two Three-column Tables -->
            <div class="row mt-4" style="background-color: #c8e3ff">
                <div class="col-md-6">
                    <h3>Right Eye</h3>
                    <input type="date" class="form-control" name="before_date">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DSPH</th>
                                <th>DCYL</th>
                                <th>AXIS</th>
                                <th>VISION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="type_of_correction_spherical_r"
                                        value="{{ $med_data->type_of_correction_spherical_r ?? '' }}"></td>
                                <td><input type="text" class="form-control" name="type_of_correction_cylinder_r"
                                        value="{{ $med_data->type_of_correction_cylinder_r ?? '' }}"></td>
                                <td><input type="text" class="form-control" name="type_of_correction_axis_r"
                                        value="{{ $med_data->type_of_correction_axis_r ?? '' }}"></td>
                                <td><select class="form-select" id="dropdown1" name="vision_information_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->vision_information_r == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3>Left Eye</h3>
                    <input type="date" class="form-control" name="before_date" disabled>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DSPH</th>
                                <th>DCYL</th>
                                <th>AXIS</th>
                                <th>VISION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="type_of_correction_spherical_l"
                                        value="{{ $med_data->type_of_correction_spherical_l ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="type_of_correction_cylinder_l"
                                        value="{{ $med_data->type_of_correction_cylinder_l ?? '' }}">
                                </td>
                                <td><input type="text" class="form-control" name="type_of_correction_axis_l"
                                        value="{{ $med_data->type_of_correction_axis_l ?? '' }}"></td>
                                <td><select class="form-select" id="dropdown1" name="corrected_vision_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->corrected_vision_l == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="row mt-4" style="background-color: #ccffc8">
                <div class="col-md-6">
                    <h3>Right Eye</h3>
                    <input type="date" class="form-control" name="after_date">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DSPH</th>
                                <th>DCYL</th>
                                <th>AXIS</th>
                                <th>VISION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="n_type_of_correction_spherical_r" value=""></td>
                                <td><input type="text" class="form-control" name="n_type_of_correction_cylinder_r" value=""></td>
                                <td><input type="text" class="form-control" name="n_type_of_correction_axis_r" value=""></td>
                                <td><select class="form-select" id="dropdown1" name="n_corrected_vision_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </select></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3>Left Eye</h3>
                    <input type="date" class="form-control" name="" disabled>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>DSPH</th>
                                <th>DCYL</th>
                                <th>AXIS</th>
                                <th>VISION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="n_type_of_correction_spherical_l" value="">
                                </td>
                                <td><input type="text" class="form-control" name="n_type_of_correction_cylinder_l" value="">
                                </td>
                                <td><input type="text" class="form-control" name="n_type_of_correction_axis_l" value=""></td>
                                <td><select class="form-select" id="dropdown1" name="n_corrected_vision_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['visioninfo'] as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </select></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Form with Four Columns -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Others</h3>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Others Eye Condition R</label>
                                <select class="form-select" id="dropdown1" name="other_eye_conditions_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['other_eye_condition'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->other_eye_conditions_r == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Others Eye Condition L</label>
                                <select class="form-select" id="dropdown1" name="other_eye_conditions_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['other_eye_condition'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->other_eye_conditions_l == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Type of Error R</label>
                                <select class="form-select" id="dropdown1" name="n_type_of_error_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['type_of_error'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->type_of_error_r == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Type of Error L</label>
                                <select class="form-select" id="dropdown1" name="n_type_of_error_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['type_of_error'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->type_of_error_l == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Refractive Error R</label>
                                <select class="form-select" id="dropdown1" name="n_refrective_error_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['refractive_error'] as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown1" class="form-label font-weight-bold">Refractive Error L</label>
                                <select class="form-select" id="dropdown1" name="n_refrective_error_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['refractive_error'] as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown3" class="form-label font-weight-bold">Change of Refrective
                                    Status R</label>
                                <select class="form-select" id="dropdown3" name="n_change_of_ref_status_r">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['change_of_ref_status'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown3" class="form-label font-weight-bold">Change of Refrective
                                    Status L</label>
                                <select class="form-select" id="dropdown3" name="n_change_of_ref_status_l">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['change_of_ref_status'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown4" class="form-label font-weight-bold">Use Mobile</label>
                                <select class="form-select" id="dropdown4" name="n_using_screen">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['using_screen'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown5" class="form-label font-weight-bold">Hour Watching</label>
                                <select class="form-select" id="dropdown5" name="n_watching_time">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['watching_time'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown6" class="form-label font-weight-bold">Covid</label>
                                <select class="form-select" id="dropdown6" name="n_covid_infected">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['covid'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown7" class="form-label font-weight-bold">Suffered any problem during
                                    online</label>
                                <select class="form-select" id="dropdown7" name="n_eye_prob_online">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['eye_prob_online'] as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown8" class="form-label font-weight-bold">Conclusion</label>
                                <select class="form-select" id="dropdown8" name="n_final_action_taken">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['conclusion'] as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $med_data->final_action_taken == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dropdown8" class="form-label font-weight-bold">Area</label>
                                <select class="form-select" id="dropdown8" name="area">
                                    <option value="">Select Option</option>
                                    @foreach ($researchConfig['area'] as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
