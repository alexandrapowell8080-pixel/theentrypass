<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index():View{
        $courses = Course::with('subjects.exams')->get();
        return view('index',compact('courses'));
    }
}
