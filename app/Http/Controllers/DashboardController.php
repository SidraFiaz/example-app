<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\FeeCollection;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard Statistics
        $totalStudents = Student::count();

        $totalClasses = StudentClass::count();

        $totalSubjects = Subject::count();

        $totalCollections = FeeCollection::count();

        $totalPaidAmount = FeeCollection::where('status', 'Paid')
            ->sum('amount');

        $totalUnpaid = FeeCollection::where('status', 'Unpaid')
            ->count();

        // Latest 5 Fee Collections
        $recentCollections = FeeCollection::with('student.studentClass')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalClasses',
            'totalSubjects',
            'totalCollections',
            'totalPaidAmount',
            'totalUnpaid',
            'recentCollections'
        ));
    }
}