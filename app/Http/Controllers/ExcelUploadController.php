<?php

namespace App\Http\Controllers;

use App\Models\EyeExamination;
use App\Models\EyeExaminationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }


    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        ini_set('max_execution_time', 240);

        $file = $request->file('file');

        try {
            // Start a database transaction
            DB::beginTransaction();

            $spreadsheet = IOFactory::load($file);
            $sheets = $spreadsheet->getAllSheets();

            foreach ($sheets as $sheet) {
                $sheetData = $sheet->toArray();
                array_shift($sheetData);

                foreach ($sheetData as $rowData) {
                    // Create EyeExamination record
                    if (!empty($rowData[27]) || !empty($rowData[28])) {
                        $eyeExamination = EyeExamination::create([
                            'region' => $rowData[1],
                            'school_cluster' => $rowData[2],
                            'name_of_teacher' => $rowData[3],
                            'student_id' => $rowData[4],
                            'student_name' => $rowData[5],
                            'class' => $rowData[6],
                            'age' => $rowData[7],
                            'sex' => $rowData[8],
                            'father_name' => $rowData[9],
                            'father_occupation' => $rowData[10],
                            'presenting_vision_r' => $rowData[11],
                            'presenting_vision_l' => $rowData[12],
                            'screening_result' => $rowData[13],
                            'eye_conditions_r' => $rowData[14],
                            'eye_conditions_l' => $rowData[15],
                            'first_action_taken' => $rowData[16],
                            'status' => 1
                            // Add mappings for other columns
                        ]);

                        // Create EyeExaminationDetail record
                        EyeExaminationDetail::create([
                            'eye_examination_id' => $eyeExamination->id,
                            'vision_information_r' => $rowData[17], // index 17
                            'vision_information_l' => $rowData[18], // index 18
                            'corrected_vision_r' => $rowData[19], // index 19
                            'corrected_vision_l' => $rowData[20], // index 20
                            'type_of_correction_spherical_r' => $rowData[21], // index 21
                            'type_of_correction_spherical_l' => $rowData[22], // index 22
                            'type_of_correction_cylinder_r' => $rowData[23], // index 23
                            'type_of_correction_cylinder_l' => $rowData[24], // index 24
                            'type_of_correction_axis_r' => $rowData[25], // index 25
                            'type_of_correction_axis_l' => $rowData[26], // index 26
                            'type_of_error_r' => $rowData[27], // index 27
                            'type_of_error_l' => $rowData[28], // index 28
                            'other_eye_conditions_r' => $rowData[29], // index 29
                            'other_eye_conditions_l' => $rowData[30], // index 30
                            'second_action_taken' => $rowData[31], // index 31
                            'concluding_diagnosis_r' => $rowData[32], // index 32
                            'concluding_diagnosis_l' => $rowData[33], // index 33
                            'final_action_taken' => $rowData[34], // index 34
                            'status' => 1
                            // Continue mapping for remaining columns
                        ]);
                    }
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            return redirect()->back()->with('success', 'Excel data imported successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Log the error or handle it appropriately
            return redirect()->back()->with('error', 'An error occurred while importing data: ' . $e->getMessage());
        }
    }

    public function deleteRows()
    {
        // Find rows in eye_examinations where school_cluster is null
        $nullSchoolClusterRows = EyeExamination::whereNull('age')->get();

        // Loop through each row and delete corresponding rows
        foreach ($nullSchoolClusterRows as $row) {
            // Delete from eye_examination_details first
            EyeExaminationDetail::where('eye_examination_id', $row->id)->delete();

            // Then delete from eye_examinations
            $row->delete();
        }

        return response()->json(['message' => 'Rows deleted successfully']);
    }

    public function index(Request $request)
    {
        $students = EyeExamination::where('status', 1)->whereNotNull('school_cluster')->paginate(100); // Change 100 to the desired number of records per page
        $researchConfig = Config::get('research');
        return view('patient-list', compact('students', 'researchConfig'));
    }

    public function details($id)
    {
        $send['data'] = EyeExamination::find($id);
        $send['med_data'] = EyeExaminationDetail::where('eye_examination_id', $id)->first();
        $send['researchConfig'] = Config::get('research');
        return view('patient-details', $send);
    }

    public function formdata(Request $request)
    {
        // dd($request->all());
        $eye_examination_id = $request->eye_examination_id;
        $id = $request->first_table;
        $validator = Validator::make($request->all(), [
            // 'menu_name' => 'required|string|max:255',

        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $first_table = EyeExamination::find($id);
            $first_table->status = 2;
            $first_table->save();

            $eyedet = EyeExaminationDetail::find($eye_examination_id);
            $eyedet->type_of_correction_spherical_r = $request->input('type_of_correction_spherical_r');
            $eyedet->type_of_correction_cylinder_r = $request->input('type_of_correction_cylinder_r');
            $eyedet->type_of_correction_axis_r = $request->input('type_of_correction_axis_r');
            $eyedet->corrected_vision_r = $request->input('corrected_vision_r');
            $eyedet->type_of_correction_spherical_l = $request->input('type_of_correction_spherical_l');
            $eyedet->type_of_correction_cylinder_l = $request->input('type_of_correction_cylinder_l');
            $eyedet->type_of_correction_axis_l = $request->input('type_of_correction_axis_l');
            $eyedet->corrected_vision_l = $request->input('corrected_vision_l');
            $eyedet->after_date = $request->input('after_date');
            $eyedet->before_date = $request->input('before_date');
            $eyedet->status = 2;
            $eyedet = $eyedet->save();

            $eyedetins = new EyeExaminationDetail();
            $eyedetins->eye_examination_id = $request->input('eye_examination_id');
            $eyedetins->type_of_correction_cylinder_r = $request->input('n_type_of_correction_cylinder_r');
            $eyedetins->type_of_correction_axis_r = $request->input('n_type_of_correction_axis_r');
            $eyedetins->type_of_correction_spherical_r = $request->input('n_type_of_correction_spherical_r');
            $eyedetins->type_of_correction_spherical_l = $request->input('n_type_of_correction_spherical_l');
            $eyedetins->type_of_correction_cylinder_l = $request->input('n_type_of_correction_cylinder_l');
            $eyedetins->type_of_correction_axis_l = $request->input('n_type_of_correction_axis_l');
            $eyedetins->corrected_vision_r = $request->input('n_corrected_vision_r');
            $eyedetins->corrected_vision_l = $request->input('n_corrected_vision_l');
            $eyedetins->type_of_error_r = $request->input('n_type_of_error_r');
            $eyedetins->type_of_error_l = $request->input('n_type_of_error_l');
            $eyedetins->other_eye_conditions_r = $request->input('other_eye_conditions_r');
            $eyedetins->other_eye_conditions_l = $request->input('other_eye_conditions_l');

            $eyedetins->refrective_error_r = $request->input('n_refrective_error_r');
            $eyedetins->refrective_error_l = $request->input('n_refrective_error_l');
            $eyedetins->change_of_ref_status_r = $request->input('n_change_of_ref_status_r');
            $eyedetins->change_of_ref_status_l = $request->input('n_change_of_ref_status_l');
            $eyedetins->after_date = $request->input('after_date');
            $eyedetins->before_date = $request->input('before_date');

            $eyedetins->using_screen = $request->input('n_using_screen');
            $eyedetins->watching_time = $request->input('n_watching_time');
            $eyedetins->covid_infected = $request->input('n_covid_infected');
            $eyedetins->eye_prob_online = $request->input('n_eye_prob_online');
            $eyedetins->final_action_taken = $request->input('n_final_action_taken');
            $eyedetins->area = $request->input('area');
            $eyedetins->status = 2;

            $query = $eyedetins->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                Session::flash('success', 'Data Successfully Updated');
                return redirect()->route('index');
            }
        }
    }

    // General Gender wise data
    public function getGenderDistribution()
    {
        $studentsData = EyeExaminationDetail::join('eye_examinations', 'eye_examination_details.eye_examination_id', '=', 'eye_examinations.id')
            ->whereNotNull('eye_examination_details.area')
            ->select(
                'eye_examination_details.area',
                DB::raw('SUM(CASE WHEN eye_examinations.sex = 1 THEN 1 ELSE 0 END) AS male_students'),
                DB::raw('SUM(CASE WHEN eye_examinations.sex = 2 THEN 1 ELSE 0 END) AS female_students'),
                DB::raw('SUM(CASE WHEN eye_examinations.sex = 3 THEN 1 ELSE 0 END) AS other_students')
            )
            ->groupBy('eye_examination_details.area')
            ->get();

        return view('area', compact('studentsData'));
    }

    // Uncorrected vision information by age for left right
    public function visionInfoTable()
    {
        // Get distinct age groups
        $ageGroups = EyeExamination::select(
            'eye_examinations.age',
            'eye_examination_details.vision_information_l',
            DB::raw('COUNT(*) AS count')
        )
            ->join('eye_examination_details', 'eye_examinations.id', '=', 'eye_examination_details.eye_examination_id')
            ->whereNotNull('eye_examinations.school_cluster')
            ->groupBy('eye_examinations.age', 'eye_examination_details.vision_information_l');

        // Count the number of rows considered for the query
        $rowCount = $ageGroups->count();

        // Get the grouped data
        $ageGroups = $ageGroups->orderBy('eye_examinations.age')
            ->get()
            ->groupBy('age');

        // Calculate percentage for each age group
        foreach ($ageGroups as &$group) {
            $total = $group->sum('count');
            $group->map(function ($item) use ($total) {
                $item->percentage = ($item->count / $total) * 100;
                return $item;
            });
        }

        // $totalCount = EyeExamination::whereNotNull('school_cluster')->count();
        $totalCount = EyeExaminationDetail::whereNotNull('area')->count();
        // echo $rowCount; exit;

        return view('uncorrected', compact('ageGroups', 'totalCount'));
    }

    // Uncorrected vision information by sex for left right
    public function visionInfoTablebySex()
    {
        // Get distinct gender groups
        $genderGroups = EyeExamination::select(
            'eye_examinations.sex',
            'eye_examination_details.vision_information_l',
            DB::raw('COUNT(*) AS count')
        )
            ->join('eye_examination_details', 'eye_examinations.id', '=', 'eye_examination_details.eye_examination_id')
            ->whereNotNull('eye_examinations.school_cluster')
            ->groupBy('eye_examinations.sex', 'eye_examination_details.vision_information_l');

        // Count the number of rows considered for the query
        $rowCount = $genderGroups->count();

        // Get the grouped data
        $genderGroups = $genderGroups->orderBy('eye_examinations.sex')
            ->get()
            ->groupBy('sex');

        // Calculate percentage for each gender group
        foreach ($genderGroups as &$group) {
            $total = $group->sum('count');
            $group->map(function ($item) use ($total) {
                $item->percentage = ($item->count / $total) * 100;
                return $item;
            });
        }

        // Total count of records with non-null area
        $totalCount = EyeExaminationDetail::whereNotNull('area')->count();

        return view('visioninfosex', compact('genderGroups', 'totalCount'));
    }


    // ///////////////////////////////////
    public function correctedVisionData()
    {
        // Query to get corrected_vision_l data for before six months
        $beforeSixMonthsData = EyeExamination::select(
            'eye_examination_details.corrected_vision_l',
            DB::raw('COUNT(*) AS count')
        )
            ->join('eye_examination_details', 'eye_examinations.id', '=', 'eye_examination_details.eye_examination_id')
            ->whereNull('eye_examination_details.area') // Before six months
            // ->where('eye_examinations.sex', 2)
            ->groupBy('eye_examination_details.corrected_vision_l');

        // Query to get corrected_vision_l data for after six months
        $afterSixMonthsData = EyeExamination::select(
            'eye_examination_details.corrected_vision_l',
            DB::raw('COUNT(*) AS count')
        )
            ->join('eye_examination_details', 'eye_examinations.id', '=', 'eye_examination_details.eye_examination_id')
            ->whereNotNull('eye_examination_details.area') // After six months
            // ->where('eye_examinations.sex', 2)
            ->groupBy('eye_examination_details.corrected_vision_l');

        // Execute queries and get the results
        $beforeSixMonthsResults = $beforeSixMonthsData->get();
        $afterSixMonthsResults = $afterSixMonthsData->get();

        // Combine the results into a single array
        $combinedResults = $this->combineResults($beforeSixMonthsResults, $afterSixMonthsResults);

        // Calculate the total count for each corrected_vision_l category
        $totalCount = $this->getTotalCount($combinedResults);

        // Calculate the percentage for each corrected_vision_l category
        foreach ($combinedResults as &$result) {
            $result->percentage = ($result->count / $totalCount) * 100;
        }

        // Return the combined results
        return $combinedResults;
    }

    // Helper function to combine the results
    private function combineResults($beforeResults, $afterResults)
    {
        $combinedResults = [];

        // Combine the results based on corrected_vision_l category
        foreach ($beforeResults as $beforeResult) {
            $category = $beforeResult->corrected_vision_l;
            $combinedResults[$category] = (object) [
                'corrected_vision_l' => $category,
                'before_six_months' => $beforeResult->count,
                'after_six_months' => 0, // Initialize after six months count to 0
                'count' => $beforeResult->count, // Add count property
            ];
        }

        // Add after six months count to the combined results
        foreach ($afterResults as $afterResult) {
            $category = $afterResult->corrected_vision_l;
            if (isset($combinedResults[$category])) {
                $combinedResults[$category]->after_six_months = $afterResult->count;
            } else {
                $combinedResults[$category] = (object) [
                    'corrected_vision_l' => $category,
                    'before_six_months' => 0, // Initialize before six months count to 0
                    'after_six_months' => $afterResult->count,
                    'count' => $afterResult->count, // Add count property
                ];
            }
        }

        // Sort the combined results by corrected_vision_l category
        ksort($combinedResults);

        return $combinedResults;
    }

    // Helper function to calculate total count
    private function getTotalCount($results)
    {
        $totalCount = 0;
        foreach ($results as $result) {
            $totalCount += $result->count;
        }
        return $totalCount;
    }

    public function showCorrectedVisionData()
    {
        $data = $this->correctedVisionData();

        // Ensure that each result has the 'count' property
        foreach ($data as $result) {
            if (!isset($result->count)) {
                $result->count = 0;
            }
        }

        return view('correctedvision', compact('data'));
    }

    // ///////////////////// Relationship between sex and refractive status
    public function typeOfErrorData()
    {
        $typeOfErrorData = EyeExamination::select(
            'ed.type_of_error_r',
            'ee.sex',
            DB::raw('COUNT(*) AS count')
        )
            ->join('eye_examination_details as ed', 'ed.eye_examination_id', '=', 'eye_examinations.id')
            ->join('eye_examinations as ee', 'ee.id', '=', 'ed.eye_examination_id')
            ->whereNotNull('ed.area') // Filter where area is not null
            ->groupBy('ed.type_of_error_r', 'ee.sex')
            ->get();

        // Combine with the type_of_error array for display
        $typeOfErrorLabels = config('research.type_of_error');
        $data = [];
        foreach ($typeOfErrorLabels as $key => $label) {
            $maleCount = $typeOfErrorData->where('type_of_error_r', $key)->where('sex', 1)->sum('count');
            $femaleCount = $typeOfErrorData->where('type_of_error_r', $key)->where('sex', 2)->sum('count');
            $data[] = [
                'type' => $label,
                'male' => $maleCount,
                'female' => $femaleCount,
            ];
        }

        return view('typeoferror', compact('data'));
    }

    public function typeOfErrorAgeData()
{
    // Get distinct age groups
    $distinctAgeGroups = EyeExamination::select('age')
        ->whereNotNull('age') // Ensure age is not null
        ->distinct()
        ->pluck('age')
        ->sort()
        ->toArray();

    $typeOfErrorAgeData = EyeExamination::select(
            'ed.type_of_error_r',
            'ee.age',
            'ee.sex',
            DB::raw('COUNT(*) AS count')
        )
        ->join('eye_examination_details as ed', 'ed.eye_examination_id', '=', 'eye_examinations.id')
        ->join('eye_examinations as ee', 'ee.id', '=', 'ed.eye_examination_id')
        ->whereNotNull('ed.area') // Filter where area is not null
        ->whereNotNull('ee.age') // Ensure age is not null
        ->groupBy('ed.type_of_error_r', 'ee.age', 'ee.sex')
        ->get();

    // Combine with the type_of_error array for display
    $typeOfErrorLabels = config('research.type_of_error');
    $data = [];
    foreach ($typeOfErrorLabels as $key => $label) {
        $typeData = [];
        foreach ([1, 2] as $sex) {
            $sexData = [];
            foreach ($distinctAgeGroups as $age) {
                $count = $typeOfErrorAgeData
                    ->where('type_of_error_r', $key)
                    ->where('sex', $sex)
                    ->where('age', $age)
                    ->sum('count');
                $sexData[] = $count;
            }
            $typeData[] = [
                'sex' => $sex == 1 ? 'Male' : 'Female',
                'counts' => $sexData,
            ];
        }
        $data[] = [
            'type' => $label,
            'age_groups' => $distinctAgeGroups,
            'data' => $typeData,
        ];
    }

    return view('type_of_error_age', compact('data'));
}

// //////// Spherical by age

 public function sphericalPowerByAge()
{
    // Query to get spherical power data for before six months
    $beforeSixMonthsData = EyeExamination::select(
        'ed.type_of_correction_spherical_r',
        'ee.age',
        DB::raw('COUNT(*) AS count')
    )
        ->join('eye_examination_details as ed', 'ed.eye_examination_id', '=', 'eye_examinations.id')
        ->join('eye_examinations as ee', 'ee.id', '=', 'ed.eye_examination_id')
        ->whereNull('ed.area') // Before six months
        ->groupBy('ed.type_of_correction_spherical_r', 'ee.age');

    // Query to get spherical power data for after six months
    $afterSixMonthsData = EyeExamination::select(
        'ed.type_of_correction_spherical_r',
        'ee.age',
        DB::raw('COUNT(*) AS count')
    )
        ->join('eye_examination_details as ed', 'ed.eye_examination_id', '=', 'eye_examinations.id')
        ->join('eye_examinations as ee', 'ee.id', '=', 'ed.eye_examination_id')
        ->whereNotNull('ed.area') // After six months
        ->groupBy('ed.type_of_correction_spherical_r', 'ee.age');

    // Combine the results into a single array
    $combinedResults = [];

    // Fetch and combine the results for before six months
    $beforeSixMonthsResults = $beforeSixMonthsData->get();
    foreach ($beforeSixMonthsResults as $result) {
        $combinedResults[$result->type_of_correction_spherical_r][$result->age]['before_six_months'] = $result->count;
    }

    // Fetch and combine the results for after six months
    $afterSixMonthsResults = $afterSixMonthsData->get();
    foreach ($afterSixMonthsResults as $result) {
        $combinedResults[$result->type_of_correction_spherical_r][$result->age]['after_six_months'] = $result->count;
    }

    // Return the combined results
    return view('spherical_power_by_age', compact('combinedResults'));
}







}
