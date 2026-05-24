<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        // Check if user is admin
        if (Session::get('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }

        // Get database statistics
        $stats = [
            'total_users' => DB::table('users')->count(),
            'total_posts' => DB::table('posts')->count(),
            'total_comments' => DB::table('comments')->count(),
            'total_reactions' => DB::table('reactions')->count(),
            'total_certificates' => DB::table('certificates')->count(),
            'total_login_logs' => DB::table('login_logs')->count(),
        ];

        // Get recent user registrations (order by id instead of created_at)
        $recent_users = DB::table('users')
            ->select('username', 'first', 'last', 'email', 'id')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Get recent login activity
        $recent_logins = DB::table('login_logs')
            ->join('users', 'login_logs.username', '=', 'users.username')
            ->select('login_logs.username', 'users.first', 'users.last', 'login_logs.login_time')
            ->orderBy('login_logs.login_time', 'desc')
            ->limit(10)
            ->get();

        // Get course enrollment statistics with detailed user data
        $course_enrollments = DB::table('user_courses')
            ->select('course_name', DB::raw('COUNT(*) as enrolled_count'))
            ->groupBy('course_name')
            ->orderBy('enrolled_count', 'desc')
            ->get();

        // Get detailed enrollment data for each course with progress
        $course_details = [];
        foreach ($course_enrollments as $enrollment) {
            $course_name = $enrollment->course_name;

            // Get enrolled users with their progress
            $enrolled_users = DB::table('user_courses')
                ->join('users', 'user_courses.username', '=', 'users.username')
                ->leftJoin('user_progress', function($join) use ($course_name) {
                    $join->on('users.username', '=', 'user_progress.username')
                         ->where('user_progress.course_name', '=', $course_name);
                })
                ->leftJoin('certificates', function($join) use ($course_name) {
                    $join->on('users.id', '=', 'certificates.user_id')
                         ->where('certificates.course_name', '=', $course_name);
                })
                ->where('user_courses.course_name', $course_name)
                ->select(
                    'users.username',
                    'users.first',
                    'users.last',
                    'users.email',
                    'user_progress.current_lesson',
                    'certificates.id as certificate_id'
                )
                ->get()
                ->map(function($user) use ($course_name) {
                    // Determine completion status based on course and lesson
                    $max_lessons = match($course_name) {
                        'C' => 6,
                        'C++' => 6,
                        'Java' => 6,
                        'Python' => 6,
                        'HTML' => 6,
                        default => 6
                    };

                    $user->is_completed = ($user->certificate_id !== null) ||
                                        ($user->current_lesson >= $max_lessons);
                    $user->progress_percentage = $user->current_lesson ?
                        min(100, round(($user->current_lesson / $max_lessons) * 100)) : 0;

                    return $user;
                });

            $course_details[$course_name] = $enrolled_users;
        }

        // Get detailed course enrollments with user info (order by user id)
        $detailed_enrollments = DB::table('user_courses')
            ->join('users', 'user_courses.username', '=', 'users.username')
            ->select('user_courses.course_name', 'users.username', 'users.first', 'users.last', 'users.id')
            ->orderBy('users.id', 'desc')
            ->limit(20)
            ->get();

        // Get all users with their course progress
        $users_progress = DB::table('users')
            ->leftJoin('user_progress', 'users.username', '=', 'user_progress.username')
            ->select(
                'users.username',
                'users.first',
                'users.last',
                'users.email',
                'users.id as registered_at',
                'user_progress.course_name',
                'user_progress.current_lesson'
            )
            ->orderBy('users.id', 'desc')
            ->get()
            ->groupBy('username');

        return view('admin_dashboard', compact(
            'stats',
            'recent_users',
            'recent_logins',
            'course_enrollments',
            'course_details'
        ));
    }
}
