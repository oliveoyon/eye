<?php

namespace App\Http\Controllers;

use App\Models\EyeExamination;
use App\Models\EyeExaminationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls',
    //     ]);

    //     $file = $request->file('file');

    //     // Load the Excel file
    //     $spreadsheet = IOFactory::load($file);

    //     // Get the first worksheet
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Iterate through rows (starting from row 2 to skip header)
    //     foreach ($sheet->getRowIterator(2) as $row) {
    //         // Extract cell values from the row
    //         $cells = $row->getCellIterator();
    //         $rowData = [];
    //         $skipFirstColumn = true;
    //         foreach ($cells as $cell) {
    //             if ($skipFirstColumn) {
    //                 $skipFirstColumn = false;
    //                 continue; // Skip the first column
    //             }
    //             $rowData[] = $cell->getValue();
    //         }

    //         // Create EyeExamination record
    //         EyeExamination::create([
    //             'region' => $rowData[0],
    //             'school_cluster' => $rowData[1],
    //             'name_of_teacher' => $rowData[2],
    //             'student_id' => $rowData[3],
    //             'student_name' => $rowData[4],
    //             'class' => $rowData[5],
    //             'age' => $rowData[6],
    //             'sex' => $rowData[7],
    //             'father_name' => $rowData[8],
    //             'father_occupation' => $rowData[9],
    //             'presenting_vision_r' => $rowData[10],
    //             'presenting_vision_l' => $rowData[11],
    //             'screening_result' => $rowData[12],
    //             'eye_conditions_r' => $rowData[13],
    //             'eye_conditions_l' => $rowData[14],
    //             'first_action_taken' => $rowData[15],
    //             // Add mappings for other columns
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Excel data imported successfully.');
    // }

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

    public function index(Request $request)
    {
        $students = EyeExamination::where('status', 1)->paginate(100); // Change 100 to the desired number of records per page
        count($students);
        // dd($students);
        return view('patient-list', compact('students'));
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
        dd($request->all());
        $eye_examination_id = $request->eye_examination_id;
        $validator = Validator::make($request->all(), [
            // 'menu_name' => 'required|string|max:255',

        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $eyedet = EyeExaminationDetail::find($eye_examination_id);
            $eyedet->type_of_correction_spherical_r = $request->input('type_of_correction_spherical_r');
            $eyedet->type_of_correction_cylinder_r = $request->input('type_of_correction_cylinder_r');
            $eyedet->type_of_correction_axis_r = $request->input('type_of_correction_axis_r');
            $eyedet->type_of_correction_spherical_l = $request->input('type_of_correction_spherical_l');
            $eyedet->type_of_correction_cylinder_l = $request->input('type_of_correction_cylinder_l');
            $eyedet->type_of_correction_axis_l = $request->input('type_of_correction_axis_l');
            // $eyedet = $eyedet->save();

            $eyedetins = new EyeExaminationDetail();
            $eyedetins->type_of_correction_cylinder_r = $request->input('n_type_of_correction_cylinder_r');
            $eyedetins->type_of_correction_axis_r = $request->input('n_type_of_correction_axis_r');
            $eyedetins->type_of_correction_spherical_r = $request->input('n_type_of_correction_spherical_r');
            $eyedetins->type_of_correction_spherical_l = $request->input('n_type_of_correction_spherical_l');
            $eyedetins->type_of_correction_cylinder_l = $request->input('n_type_of_correction_cylinder_l');
            $eyedetins->type_of_correction_axis_l = $request->input('n_type_of_correction_axis_l');
            $eyedetins->type_of_error_r = $request->input('n_type_of_error_r');
            $eyedetins->type_of_error_l = $request->input('n_type_of_error_l');
            $eyedetins->other_eye_conditions_r = $request->input('other_eye_conditions_r');
            $eyedetins->other_eye_conditions_l = $request->input('other_eye_conditions_l');

            $eyedetins->refrective_error = $request->input('n_refrective_error');
            $eyedetins->change_of_ref_status = $request->input('n_change_of_ref_status');
            $eyedetins->using_screen = $request->input('n_using_screen');
            $eyedetins->watching_time = $request->input('n_watching_time');
            $eyedetins->covid_infected = $request->input('n_covid_infected');
            $eyedetins->eye_prob_online = $request->input('n_eye_prob_online');
            $eyedetins->final_action_taken = $request->input('n_final_action_taken');
            $eyedetins->status = 2;

            // $query = $eyedetins->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Menu has been successfully saved', 'redirect' => 'admin/menu-list']);
            }
        }
    }
}
