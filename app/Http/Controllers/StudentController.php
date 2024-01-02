<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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
            'status'=>200,
        ]);
    }
}
