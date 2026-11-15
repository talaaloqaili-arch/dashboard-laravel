<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLecturers = Lecturer::where('is_activated', true)->count();

        $totalCourses = Course::count();

        $totalLectures = Lecture::count();

        $totalEnrollments = User::whereHas('courses')
            ->whereHas('lecturer', function ($query) {
                $query->where('is_activated', true);
            })->count();

        return view('dashboard', compact(
            'totalLecturers',
            'totalCourses',
            'totalLectures',
            'totalEnrollments'
        ));
    }
}
