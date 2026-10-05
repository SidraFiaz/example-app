<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class BrowserTitle
{
    /**
     * Build the full browser tab title.
     */
    public static function make(?string $explicit = null): string
    {
        $appName = (string) config('app.name');
        $page = filled($explicit) ? trim(strip_tags($explicit)) : static::fromRoute();

        if ($page === null || $page === '' || strcasecmp($page, $appName) === 0) {
            return $appName;
        }

        return $page.' | '.$appName;
    }

    /**
     * Resolve a page label from the current route name.
     */
    public static function fromRoute(?string $routeName = null): ?string
    {
        $routeName = $routeName ?: Route::currentRouteName();

        if (! $routeName) {
            return null;
        }

        $exact = [
            'dashboard' => 'Dashboard',
            'profile.edit' => 'Profile',
            'reports.index' => 'Reports',
            'classes' => 'Classes',
            'classes.create' => 'Create Class',
            'classes.edit' => 'Edit Class',
            'login' => 'Login',
            'register' => 'Register',
            'password.request' => 'Forgot Password',
            'password.reset' => 'Reset Password',
            'password.confirm' => 'Confirm Password',
            'verification.notice' => 'Verify Email',
        ];

        if (isset($exact[$routeName])) {
            return $exact[$routeName];
        }

        // More specific prefixes first.
        $prefixes = [
            'admission-tests' => 'Admission Test',
            'student-promotions' => 'Student Promotion',
            'student-marks' => 'Student Marks',
            'register-students' => 'Register Students',
            'parent-meetings' => 'Parent Meeting',
            'fee-collections' => 'Receive Fees List',
            'fee-process' => 'Fee Process',
            'fee-types' => 'Fee Types',
            'paper-funds' => 'Paper Funds',
            'advance-fees' => 'Advance Fees',
            'class-fees' => 'Class Fees',
            'class-groups' => 'Class Groups',
            'result-grades' => 'Result Grades',
            'date-sheets' => 'Date Sheet',
            'session-periods' => 'Session Periods',
            'admission' => 'Admission',
            'student' => 'Students',
            'attendance' => 'Attendance',
            'adjustment' => 'Adjustment',
            'subjects' => 'Subjects',
            'exams' => 'Exams',
            'grades' => 'Grades',
            'fees' => 'Fees',
            'discounts' => 'Discounts',
            'sessions' => 'Sessions',
            'transport' => 'Transport',
            'schedules' => 'Time Table',
            'sections' => 'Sections',
            'reports' => 'Reports',
        ];

        foreach ($prefixes as $prefix => $label) {
            if ($routeName === $prefix || str_starts_with($routeName, $prefix.'.')) {
                return $label;
            }
        }

        return null;
    }
}
