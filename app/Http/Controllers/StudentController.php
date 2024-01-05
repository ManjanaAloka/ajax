<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    protected $student;
    public function __construct()
    {
        $this->student = new Student();
    }

    public function store(Request $request)
    {
        $file = $request->file('avatar');
        $fileName = time() . '.' . $file->getClientOriginalExtension(); //file extention eka ganna  12785576.jpg
        $file->storeAs('public/images', $fileName);

        $stData = [
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $fileName,
        ];

        Student::create($stData);

        return response()->json([
            'status' => 200,
            'std_name' => $request->name,
        ]);
    }

    public function showData()
    {
        $students = Student::all();
        $response = '';
        foreach ($students as $key => $student) {
            $response .= '
               <tr>
                   <td>' . ++$key . '</td>
                   <td> <img src="storage/images/' . $student->avatar . '" alt="asd" style="width: 50px;height: 50px;" class="img-fluid img-thumbnail rounded-circle"></td>
                   <td>' . $student->name . '</td>
                   <td>' . $student->email . '</td>
                   <td><a href="#" id="' . $student->id . '" data-toggle="modal" data-target="#edit_student" class="edit_student">Edit</a> | <a href="" class="Delete-student" id="' . $student->id . '">Delete</a></td>
               </tr>';
        }
        echo $response;
    }

    public function findData(Request $request)
    {
        $std_id = $request->id;
        $student = Student::find($std_id);
        return response()->json($student);
    }

    public function updateStd(Request $response)
    {
        $fileName = '';
        $student = Student::find($response->std_id);
        if ($response->hasFile('edit_avatar')) {
            // file ekak thiyeda kiyala balanava
            $file = $response->file('edit_avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); //file extention eka ganna  12785576.jpg
            $file->storeAs('public/images', $fileName);
            if ($student->avatar) {
                Storage::delete('public/images/' . $student->avatar);
            } else {
                $fileName = $student->avatar;
            }
        } else {
            $fileName = $student->avatar;
        }

        $studata = [
            'name' => $response->name,
            'email' => $response->email,
            'avatar' => $fileName,
        ];
        $student->update($studata);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function delStudent(Request $response)
    {
        $student = Student::find($response->id);
        Storage::delete('public/images/' . $student->avatar);
        $student->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
