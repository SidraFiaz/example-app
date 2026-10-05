<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FeeCollectionController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\ClassFeeController;
use App\Http\Controllers\StudentMarksController;
use App\Http\Controllers\FeeProcessController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentPromotionController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionPeriodController;
use App\Http\Controllers\StudentAttachmentController;
use App\Http\Controllers\AdmissionFeeController;
use App\Http\Controllers\TransferStudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdvanceFeeController;
use App\Http\Controllers\ClassGroupController;
use App\Http\Controllers\ResultGradeController;
use App\Http\Controllers\PaperFundController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\RegisterStudentController;
use App\Http\Controllers\ParentMeetingController;
use App\Http\Controllers\AdmissionTestController;
use App\Http\Controllers\DateSheetController;
use App\Http\Controllers\ScheduleController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | School Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('reports.index');


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Attendance
    |--------------------------------------------------------------------------
    */

    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendance', [AttendanceController::class, 'store'])
        ->name('attendance.store');

    Route::get('/attendance/report', [AttendanceController::class, 'report'])
        ->name('attendance.report');

    Route::get(
        '/attendance/report/sections/{class_id}',
        [AttendanceController::class, 'getReportSections']
    )->name('attendance.report.sections');

    Route::get(
        '/attendance/report/students/{section_id}',
        [AttendanceController::class, 'getReportStudents']
    )->name('attendance.report.students');

    Route::get('/attendance/search', [AttendanceController::class, 'search'])
        ->name('attendance.search');


    /*
    |--------------------------------------------------------------------------
    | Classes
    |--------------------------------------------------------------------------
    */

    Route::get('/classes', [ClassesController::class, 'index'])
        ->name('classes');

    Route::get('/classes/create', [ClassesController::class, 'create'])
        ->name('classes.create');

    Route::post('/classes/store', [ClassesController::class, 'store'])
        ->name('classes.store');

    Route::get('/classes/edit/{id}', [ClassesController::class, 'edit'])
        ->name('classes.edit');

    Route::put('/classes/update/{id}', [ClassesController::class, 'update'])
        ->name('classes.update');

    Route::delete('/classes/delete/{id}', [ClassesController::class, 'destroy'])
        ->name('classes.delete');
       
/*
|--------------------------------------------------------------------------
| Class Groups
|--------------------------------------------------------------------------
*/

Route::get('/class-groups', [ClassGroupController::class, 'index'])
    ->name('class-groups.index');

Route::get('/class-groups/create', [ClassGroupController::class, 'create'])
    ->name('class-groups.create');

Route::post('/class-groups', [ClassGroupController::class, 'store'])
    ->name('class-groups.store');

Route::delete('/class-groups/{classGroup}', [ClassGroupController::class, 'destroy'])
    ->name('class-groups.destroy');


    /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/classes/{class_id}/sections',
        [SectionController::class, 'index']
    )->name('sections.index');

    Route::get(
        '/classes/{class_id}/sections/create',
        [SectionController::class, 'create']
    )->name('sections.create');

    Route::post(
        '/classes/{class_id}/sections/store',
        [SectionController::class, 'store']
    )->name('sections.store');

    Route::delete(
        '/classes/{class_id}/sections/delete/{id}',
        [SectionController::class, 'destroy']
    )->name('sections.delete');


    /*
    |--------------------------------------------------------------------------
    | Sections AJAX
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/get-sections/{class_id}',
        [SectionController::class, 'getSections']
    )->name('get.sections');


    /*
    |--------------------------------------------------------------------------
    | Fees
    |--------------------------------------------------------------------------
    */

    Route::get('/fees', [FeeController::class, 'index'])
        ->name('fees.index');

    Route::get('/fees/create', [FeeController::class, 'create'])
        ->name('fees.create');

    Route::post('/fees', [FeeController::class, 'store'])
        ->name('fees.store');

    Route::get('/fees/{fee}', [FeeController::class, 'show'])
        ->name('fees.show');

    Route::get('/fees/{fee}/edit', [FeeController::class, 'edit'])
        ->name('fees.edit');

    Route::put('/fees/{fee}', [FeeController::class, 'update'])
        ->name('fees.update');

    Route::delete('/fees/{fee}', [FeeController::class, 'destroy'])
        ->name('fees.destroy');


    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */

    Route::resource('student', StudentController::class);




    

    /*
    |--------------------------------------------------------------------------
    | Admissions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admission/export',
        [AdmissionController::class, 'export']
    )->name('admission.export');

    Route::get(
        '/admission/deleted',
        [AdmissionController::class, 'deleted']
    )->name('admission.deleted');

    Route::post(
        '/admission/{id}/restore',
        [AdmissionController::class, 'restore']
    )->name('admission.restore');

    Route::get(
        '/admission/polio-report/{class_id}',
        [AdmissionController::class, 'polioReport']
    )->name('admission.polio-report');

    Route::resource('admission', AdmissionController::class);

    Route::patch(
        '/admission/{admission}/basic-info',
        [AdmissionController::class, 'updateBasicInfo']
    )->name('admission.updateBasicInfo');

    Route::patch(
        '/admission/{admission}/class-section',
        [AdmissionController::class, 'updateClassSection']
    )->name('admission.updateClassSection');


    /*
    |--------------------------------------------------------------------------
    | Student Attachments
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admission/{admission}/attachments',
        [StudentAttachmentController::class, 'create']
    )->name('student-attachments.create');

    Route::post(
        '/admission/{admission}/attachments',
        [StudentAttachmentController::class, 'store']
    )->name('student-attachments.store');

    Route::get(
        '/student-attachments/{studentAttachment}/download',
        [StudentAttachmentController::class, 'download']
    )->name('student-attachments.download');

    Route::delete(
        '/student-attachments/{studentAttachment}',
        [StudentAttachmentController::class, 'destroy']
    )->name('student-attachments.destroy');


    /*
    |--------------------------------------------------------------------------
    | Admission Fees
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admission/{admission}/fees',
        [AdmissionFeeController::class, 'create']
    )->name('admission-fees.create');

    Route::post(
        '/admission/{admission}/fees',
        [AdmissionFeeController::class, 'store']
    )->name('admission-fees.store');

    Route::get(
        '/admission/{admission}/leaving-certificate',
        [AdmissionController::class, 'leavingCertificate']
    )->name('admission.leaving-certificate');

    Route::patch(
        '/admission-fees/{admissionFee}',
        [AdmissionFeeController::class, 'update']
    )->name('admission-fees.update');

    Route::delete(
        '/admission-fees/{admissionFee}',
        [AdmissionFeeController::class, 'destroy']
    )->name('admission-fees.destroy');


    /*
    |--------------------------------------------------------------------------
    | Transfer Student
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admission/{admission}/transfer',
        [TransferStudentController::class, 'create']
    )->name('admission.transfer.create');

    Route::post(
        '/admission/{admission}/transfer',
        [TransferStudentController::class, 'store']
    )->name('admission.transfer.store');


    /*
    |--------------------------------------------------------------------------
    | Subjects
    |--------------------------------------------------------------------------
    */

    Route::resource('subjects', SubjectController::class);


    /*
    |--------------------------------------------------------------------------
    | Fee Collections
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fee-collections',
        [FeeCollectionController::class, 'index']
    )->name('fee-collections.index');

    Route::get(
        '/fee-collections/create',
        [FeeCollectionController::class, 'create']
    )->name('fee-collections.create');

    Route::post(
        '/fee-collections',
        [FeeCollectionController::class, 'store']
    )->name('fee-collections.store');

    Route::get(
        '/fee-collections/{fee_collection}/receive',
        [FeeCollectionController::class, 'receive']
    )->name('fee-collections.receive');

    Route::put(
        '/fee-collections/{fee_collection}/receive',
        [FeeCollectionController::class, 'receiveUpdate']
    )->name('fee-collections.receive.update');

    Route::get(
        '/fee-collections/{fee_collection}/edit',
        [FeeCollectionController::class, 'edit']
    )->name('fee-collections.edit');

    Route::get(
        '/fee-collections/{fee_collection}/month-edit',
        [FeeCollectionController::class, 'editMonth']
    )->name('fee-collections.month-edit');

    Route::put(
        '/fee-collections/{fee_collection}/month-edit',
        [FeeCollectionController::class, 'updateMonth']
    )->name('fee-collections.month-update');

    Route::delete(
        '/fee-collections/{fee_collection}/month',
        [FeeCollectionController::class, 'destroyMonth']
    )->name('fee-collections.month-destroy');

    Route::put(
        '/fee-collections/{fee_collection}/month-receive',
        [FeeCollectionController::class, 'receiveMonth']
    )->name('fee-collections.month-receive');

    Route::put(
        '/fee-collections/{fee_collection}',
        [FeeCollectionController::class, 'update']
    )->name('fee-collections.update');

    Route::get(
        '/fee-collections/{fee_collection}/history',
        [FeeCollectionController::class, 'history']
    )->name('fee-collections.history');

    Route::get(
        '/fee-collections/{fee_collection}/challan',
        [FeeCollectionController::class, 'challan']
    )->name('fee-collections.challan');

    Route::get(
        '/fee-collections/{fee_collection}/fee-warning',
        [FeeCollectionController::class, 'feeWarning']
    )->name('fee-collections.fee-warning');


    /*
    |--------------------------------------------------------------------------
    | FAMILY DEFAULTER LIST
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fee-collections/family-defaulters',
        [FeeCollectionController::class, 'familyDefaulters']
    )->name('fee-collections.family-defaulters');


    /*
    |--------------------------------------------------------------------------
    | Fee Collection Show
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fee-collections/{fee_collection}',
        [FeeCollectionController::class, 'show']
    )->name('fee-collections.show');


    /*
    |--------------------------------------------------------------------------
    | Fee Collection Delete
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/fee-collections/{fee_collection}',
        [FeeCollectionController::class, 'destroy']
    )->name('fee-collections.destroy');


    /*
    |--------------------------------------------------------------------------
    | Fee Types
    |--------------------------------------------------------------------------
    */

    Route::get('/fee-types', [FeeTypeController::class, 'index'])
        ->name('fee-types.index');

    Route::get('/fee-types/{fee_type}/edit', [FeeTypeController::class, 'edit'])
        ->name('fee-types.edit');

    Route::put('/fee-types/{fee_type}', [FeeTypeController::class, 'update'])
        ->name('fee-types.update');


    /*
    |--------------------------------------------------------------------------
    | Paper Funds
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/paper-funds',
        [PaperFundController::class, 'index']
    )->name('paper-funds.index');


    /*
    |--------------------------------------------------------------------------
    | Class Fees
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/classes/{class}/fees',
        [ClassFeeController::class, 'index']
    )->name('class-fees.index');

    Route::get(
        '/classes/{class}/fees/create',
        [ClassFeeController::class, 'create']
    )->name('class-fees.create');

    Route::post(
        '/classes/{class}/fees',
        [ClassFeeController::class, 'store']
    )->name('class-fees.store');

    Route::post(
        '/classes/{class}/fees/process',
        [ClassFeeController::class, 'process']
    )->name('class-fees.process');


    /*
    |--------------------------------------------------------------------------
    | Student Marks
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/student-marks/subjects/{class}',
        [StudentMarksController::class, 'getSubjects']
    )->name('student-marks.subjects');

    Route::get(
        '/get-students/{class}',
        [StudentMarksController::class, 'getStudents']
    )->name('student-marks.students');

    Route::get(
        '/student-marks/sheet-students',
        [StudentMarksController::class, 'sheetStudents']
    )->name('student-marks.sheet-students');

    Route::post(
        '/student-marks/sheet',
        [StudentMarksController::class, 'storeSheet']
    )->name('student-marks.sheet.store');

    Route::resource('student-marks', StudentMarksController::class)
        ->except(['show', 'store']);


   /*
|--------------------------------------------------------------------------
| Grades
|--------------------------------------------------------------------------
*/

Route::get('/grades', [GradeController::class, 'index'])
    ->name('grades.index');

Route::post('/grades', [GradeController::class, 'store'])
    ->name('grades.store');

Route::put('/grades/{grade}', [GradeController::class, 'update'])
    ->name('grades.update');

Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])
    ->name('grades.destroy');


  /*
|--------------------------------------------------------------------------
| Result Grades
|--------------------------------------------------------------------------
*/

Route::get(
    '/result-grades',
    [ResultGradeController::class, 'index']
)->name('result-grades.index');

Route::get(
    '/result-grades/available-grades',
    [ResultGradeController::class, 'availableGrades']
)->name('result-grades.available-grades');

Route::post(
    '/result-grades',
    [ResultGradeController::class, 'store']
)->name('result-grades.store');

Route::put(
    '/result-grades/{resultGrade}',
    [ResultGradeController::class, 'update']
)->name('result-grades.update');

Route::delete(
    '/result-grades/{resultGrade}',
    [ResultGradeController::class, 'destroy']
)->name('result-grades.destroy');

    /*
    |--------------------------------------------------------------------------
    | Exams
    |--------------------------------------------------------------------------
    */

    Route::resource('exams', ExamController::class);

    /*
|--------------------------------------------------------------------------
| Exam PDF Report
|--------------------------------------------------------------------------
*/

Route::get(
    '/exam-pdf-report',
    [ReportController::class, 'examPdfReport']
)->name('exam-pdf-report.index');

Route::get(
    '/exam-pdf-report/sections/{classId}',
    [ReportController::class, 'examPdfReportSections']
)->name('exam-pdf-report.sections');

Route::get(
    '/exam-pdf-report/exams/{sessionId}',
    [ReportController::class, 'examPdfReportExams']
)->name('exam-pdf-report.exams');

Route::get(
    '/exam-pdf-report/students',
    [ReportController::class, 'examPdfReportStudents']
)->name('exam-pdf-report.students');


    /*
    |--------------------------------------------------------------------------
    | Fee Process
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fee-process',
        [FeeProcessController::class, 'index']
    )->name('fee-process.index');

    Route::post(
        '/fee-process',
        [FeeProcessController::class, 'store']
    )->name('fee-process.store');

    Route::get(
        '/fee-process-list',
        [FeeProcessController::class, 'processedFees']
    )->name('fee-process.list');

    Route::delete(
        '/fee-process/{id}',
        [FeeProcessController::class, 'destroy']
    )->name('fee-process.destroy');

    Route::get(
        '/fee-process/{id}/view',
        [FeeProcessController::class, 'show']
    )->name('fee-process.show');

    Route::get(
        '/fee-process/process-lines',
        [FeeProcessController::class, 'processLines']
    )->name('fee-process.process-lines');


    /*
    |--------------------------------------------------------------------------
    | Student Promotions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/student-promotions',
        [StudentPromotionController::class, 'index']
    )->name('student-promotions.index');

    Route::put(
        '/student-promotions/{student}',
        [StudentPromotionController::class, 'promote']
    )->name('student-promotions.promote');

    Route::get(
        '/student-promotions/history',
        [StudentPromotionController::class, 'history']
    )->name('student-promotions.history');


    /*
    |--------------------------------------------------------------------------
    | Adjustment
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/adjustment',
        [AdjustmentController::class, 'index']
    )->name('adjustment.index');

    Route::post(
        '/adjustment',
        [AdjustmentController::class, 'store']
    )->name('adjustment.store');


   /*
|--------------------------------------------------------------------------
| Advance Fees
|--------------------------------------------------------------------------
*/

Route::get(
    '/advance-fees',
    [AdvanceFeeController::class, 'index']
)->name('advance-fees.index');

Route::get(
    '/advance-fees/create',
    [AdvanceFeeController::class, 'create']
)->name('advance-fees.create');

Route::post(
    '/advance-fees',
    [AdvanceFeeController::class, 'store']
)->name('advance-fees.store');

Route::get(
    '/advance-fees/{id}/view',
    [AdvanceFeeController::class, 'show']
)->name('advance-fees.show');

Route::get(
    '/advance-fees/{id}/edit',
    [AdvanceFeeController::class, 'edit']
)->name('advance-fees.edit');

Route::put(
    '/advance-fees/{id}',
    [AdvanceFeeController::class, 'update']
)->name('advance-fees.update');

Route::delete(
    '/advance-fees/{id}',
    [AdvanceFeeController::class, 'destroy']
)->name('advance-fees.destroy');


    /*
    |--------------------------------------------------------------------------
    | Transport
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transport',
        [TransportController::class, 'index']
    )->name('transport.index');

    Route::post(
        '/transport',
        [TransportController::class, 'store']
    )->name('transport.store');

    Route::get(
        '/transport/{transport}/edit',
        [TransportController::class, 'edit']
    )->name('transport.edit');

    Route::put(
        '/transport/{transport}',
        [TransportController::class, 'update']
    )->name('transport.update');

    Route::delete(
        '/transport/{transport}',
        [TransportController::class, 'destroy']
    )->name('transport.destroy');


    /*
    |--------------------------------------------------------------------------
    | Parent Meetings
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/parent-meetings',
        [ParentMeetingController::class, 'index']
    )->name('parent-meetings.index');

    Route::post(
        '/parent-meetings',
        [ParentMeetingController::class, 'store']
    )->name('parent-meetings.store');

    Route::get(
        '/parent-meetings/{parentMeeting}/edit',
        [ParentMeetingController::class, 'edit']
    )->name('parent-meetings.edit');

    Route::put(
        '/parent-meetings/{parentMeeting}',
        [ParentMeetingController::class, 'update']
    )->name('parent-meetings.update');

    Route::delete(
        '/parent-meetings/{parentMeeting}',
        [ParentMeetingController::class, 'destroy']
    )->name('parent-meetings.destroy');


    /*
    |--------------------------------------------------------------------------
    | Admission Tests
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admission-tests',
        [AdmissionTestController::class, 'index']
    )->name('admission-tests.index');

    Route::get(
        '/admission-tests/create',
        [AdmissionTestController::class, 'create']
    )->name('admission-tests.create');

    Route::post(
        '/admission-tests',
        [AdmissionTestController::class, 'store']
    )->name('admission-tests.store');

    Route::get(
        '/admission-tests/{admissionTest}/print',
        [AdmissionTestController::class, 'print']
    )->name('admission-tests.print');


    /*
    |--------------------------------------------------------------------------
    | Date Sheets
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/date-sheets',
        [DateSheetController::class, 'index']
    )->name('date-sheets.index');

    Route::get(
        '/date-sheets/create',
        [DateSheetController::class, 'create']
    )->name('date-sheets.create');

    Route::post(
        '/date-sheets',
        [DateSheetController::class, 'store']
    )->name('date-sheets.store');

    Route::get(
        '/date-sheets/{dateSheet}/edit',
        [DateSheetController::class, 'edit']
    )->name('date-sheets.edit');

    Route::put(
        '/date-sheets/{dateSheet}',
        [DateSheetController::class, 'update']
    )->name('date-sheets.update');


    /*
    |--------------------------------------------------------------------------
    | Schedules / Time Table
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/schedules',
        [ScheduleController::class, 'index']
    )->name('schedules.index');

    Route::get(
        '/schedules/create',
        [ScheduleController::class, 'create']
    )->name('schedules.create');

    Route::post(
        '/schedules',
        [ScheduleController::class, 'store']
    )->name('schedules.store');

    Route::get(
        '/schedules/{schedule}',
        [ScheduleController::class, 'show']
    )->name('schedules.show');

    Route::get(
        '/schedules/{schedule}/edit',
        [ScheduleController::class, 'edit']
    )->name('schedules.edit');

    Route::put(
        '/schedules/{schedule}',
        [ScheduleController::class, 'update']
    )->name('schedules.update');

    Route::delete(
        '/schedules/{schedule}',
        [ScheduleController::class, 'destroy']
    )->name('schedules.destroy');


    /*
    |--------------------------------------------------------------------------
    | Register Students 9th,10th
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/register-students',
        [RegisterStudentController::class, 'index']
    )->name('register-students.index');

    Route::get(
        '/register-students/create',
        [RegisterStudentController::class, 'create']
    )->name('register-students.create');

    Route::post(
        '/register-students',
        [RegisterStudentController::class, 'store']
    )->name('register-students.store');

    Route::get(
        '/register-students/export',
        [RegisterStudentController::class, 'export']
    )->name('register-students.export');

    Route::get(
        '/register-students/students/{classId}',
        [RegisterStudentController::class, 'getStudents']
    )->name('register-students.students');

    Route::get(
        '/register-students/{registerStudent}/edit',
        [RegisterStudentController::class, 'edit']
    )->name('register-students.edit');

    Route::put(
        '/register-students/{registerStudent}',
        [RegisterStudentController::class, 'update']
    )->name('register-students.update');

    Route::delete(
        '/register-students/{registerStudent}',
        [RegisterStudentController::class, 'destroy']
    )->name('register-students.destroy');


    /*
    |--------------------------------------------------------------------------
    | Discounts
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/discounts',
        [DiscountController::class, 'index']
    )->name('discounts.index');

    Route::get(
        '/discounts/create',
        [DiscountController::class, 'create']
    )->name('discounts.create');

    Route::post(
        '/discounts',
        [DiscountController::class, 'store']
    )->name('discounts.store');

    Route::delete(
        '/discounts/{discount}',
        [DiscountController::class, 'destroy']
    )->name('discounts.destroy');


    /*
    |--------------------------------------------------------------------------
    | Academic Sessions
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sessions',
        [SessionController::class, 'index']
    )->name('sessions.index');

    Route::get(
        '/sessions/create',
        [SessionController::class, 'create']
    )->name('sessions.create');

    Route::post(
        '/sessions',
        [SessionController::class, 'store']
    )->name('sessions.store');

    Route::get(
        '/sessions/{session}/edit',
        [SessionController::class, 'edit']
    )->name('sessions.edit');

    Route::put(
        '/sessions/{session}',
        [SessionController::class, 'update']
    )->name('sessions.update');

    Route::delete(
        '/sessions/{session}',
        [SessionController::class, 'destroy']
    )->name('sessions.destroy');


    /*
    |--------------------------------------------------------------------------
    | Session Periods
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sessions/{session}/periods',
        [SessionPeriodController::class, 'index']
    )->name('session-periods.index');

    Route::post(
        '/sessions/{session}/periods/generate',
        [SessionPeriodController::class, 'generate']
    )->name('session-periods.generate');

    Route::patch(
        '/session-periods/{sessionPeriod}/toggle',
        [SessionPeriodController::class, 'toggle']
    )->name('session-periods.toggle');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';