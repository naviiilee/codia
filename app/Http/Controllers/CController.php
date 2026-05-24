<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CController extends Controller
{
    // =========================================================
    // SHOW C COURSE
    // =========================================================
    public function index()
    {
        $user = session('username');

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C')
            ->first();

        if (!$progress) {
            DB::table('user_progress')->insert([
                'username'       => $user,
                'course_name'    => 'C',
                'current_lesson' => 1
            ]);
            $current_lesson = 1;
        } else {
            $current_lesson = $progress->current_lesson;
        }

        DB::table('user_courses')->updateOrInsert(
            ['username' => $user, 'course_name' => 'C']
        );

        // Fetch certificate if user has completed the course
        $userRecord = DB::table('users')->where('username', $user)->first();
        $certificate = null;
        if ($userRecord) {
            $certificate = DB::table('certificates')
                ->where('user_id', $userRecord->id)
                ->where('course_name', 'C')
                ->first();
        }

        return view('c_course', [
            'current_lesson' => $current_lesson,
            'showQuiz'       => false,
            'certificate'    => $certificate,
        ]);
    }

    // =========================================================
    // LESSON 1 QUIZ
    // =========================================================
    public function quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'C')
            ->value('current_lesson');

        return view('c_course', [
            'showQuiz'       => true,
            'current_lesson' => $current_lesson,
            'quiz_type'      => 'c_lesson1',
        ]);
    }

    public function submitQuiz(Request $request)
    {
        // Assuming 10 questions, adjust as needed
        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        // Correct answers for Lesson 1 Quiz
        $score = 0;
        if ($request->q1  == 'a') $score++; // Dennis Ritchie
        if ($request->q2  == 'c') $score++; // .c
        if ($request->q3  == 'd') $score++; // printf()
        if ($request->q4  == 'c') $score++; // <stdio.h>
        if ($request->q5  == 'd') $score++; // int
        if ($request->q6  == 'b') $score++; // Adds a new line
        if ($request->q7  == 'c') $score++; // // This is a comment
        if ($request->q8  == 'b') $score++; // int main()
        if ($request->q9  == 'c') $score++; // The program ended successfully
        if ($request->q10 == 'c') $score++; // Tab space

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'C')
            ->first();

        if ($passed && $progress->current_lesson == 1) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'C')
                ->update(['current_lesson' => 2]);
        }

        return redirect()->route('c.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'c_lesson1',
        ]);
    }

    // Add similar methods for other lessons: lesson2Quiz, lesson2Submit, etc.
    // For brevity, I'll add placeholders

    public function lesson2Quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'C')
            ->value('current_lesson');

        if ($current_lesson < 2) {
            return redirect()->route('c.course')->with('error', 'Finish Lesson 1 first!');
        }

        return view('c_course', [
            'showQuiz'       => 'lesson2',
            'current_lesson' => $current_lesson,
            'quiz_type'      => 'c_lesson2',
        ]);
    }

    public function lesson2Submit(Request $request)
    {
        // Validation
        $request->validate([
            'q1' => 'required', 'q2' => 'required', 'q3' => 'required',
            'q4' => 'required', 'q5' => 'required', 'q6' => 'required',
            'q7' => 'required', 'q8' => 'required', 'q9' => 'required',
            'q10' => 'required',
        ]);

        // Placeholder correct answers - update as needed
        $score = 0;
        if ($request->q1 == 'a') $score++;
        if ($request->q2 == 'a') $score++;
        if ($request->q3 == 'a') $score++;
        if ($request->q4 == 'a') $score++;
        if ($request->q5 == 'a') $score++;
        if ($request->q6 == 'a') $score++;
        if ($request->q7 == 'a') $score++;
        if ($request->q8 == 'a') $score++;
        if ($request->q9 == 'a') $score++;
        if ($request->q10 == 'a') $score++;

        $percentage = ($score / 10) * 100;
        $passed = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'C')
            ->first();

        if ($passed && $progress->current_lesson == 2) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'C')
                ->update(['current_lesson' => 3]);
        }

        return redirect()->route('c.course')->with([
            'score' => $score,
            'total' => 10,
            'percentage' => $percentage,
            'passed' => $passed,
            'quiz' => 'c_lesson2',
        ]);
    }

    // Add similar methods for other lessons
    public function lesson3Quiz()
    {
        $current_lesson = DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->value('current_lesson');
        if ($current_lesson < 3) return redirect()->route('c.course')->with('error', 'Finish Lesson 2 first!');
        return view('c_course', ['showQuiz' => 'lesson3', 'current_lesson' => $current_lesson, 'quiz_type' => 'c_lesson3']);
    }

    public function lesson3Submit(Request $request)
    {
        $score = 0; // Calculate score
        $percentage = ($score / 10) * 100;
        $passed = $percentage >= 75;
        if ($passed) DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->update(['current_lesson' => 4]);
        return redirect()->route('c.course')->with(['score' => $score, 'total' => 10, 'percentage' => $percentage, 'passed' => $passed, 'quiz' => 'c_lesson3']);
    }

    public function lesson4Quiz()
    {
        $current_lesson = DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->value('current_lesson');
        if ($current_lesson < 4) return redirect()->route('c.course')->with('error', 'Finish Lesson 3 first!');
        return view('c_course', ['showQuiz' => 'lesson4', 'current_lesson' => $current_lesson, 'quiz_type' => 'c_lesson4']);
    }

    public function lesson4Submit(Request $request)
    {
        $score = 0;
        $percentage = ($score / 10) * 100;
        $passed = $percentage >= 75;
        if ($passed) DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->update(['current_lesson' => 5]);
        return redirect()->route('c.course')->with(['score' => $score, 'total' => 10, 'percentage' => $percentage, 'passed' => $passed, 'quiz' => 'c_lesson4']);
    }

    public function lesson5Quiz()
    {
        $current_lesson = DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->value('current_lesson');
        if ($current_lesson < 5) return redirect()->route('c.course')->with('error', 'Finish Lesson 4 first!');
        return view('c_course', ['showQuiz' => 'lesson5', 'current_lesson' => $current_lesson, 'quiz_type' => 'c_lesson5']);
    }

    public function lesson5Submit(Request $request)
    {
        $score = 0;
        $percentage = ($score / 10) * 100;
        $passed = $percentage >= 75;
        if ($passed) DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->update(['current_lesson' => 6]);
        return redirect()->route('c.course')->with(['score' => $score, 'total' => 10, 'percentage' => $percentage, 'passed' => $passed, 'quiz' => 'c_lesson5']);
    }

    public function finalExam()
    {
        $current_lesson = DB::table('user_progress')->where('username', session('username'))->where('course_name', 'C')->value('current_lesson');
        if ($current_lesson < 6) return redirect()->route('c.course')->with('error', 'Finish all lessons first!');
        return view('c_course', ['showQuiz' => 'final', 'current_lesson' => $current_lesson, 'quiz_type' => 'c_final']);
    }

    public function finalExamSubmit(Request $request)
    {
        // Validate all 50 questions
        $rules = [];
        for ($i = 1; $i <= 50; $i++) {
            $rules["q$i"] = 'required';
        }
        $request->validate($rules);

        // Answer key for C Programming Final Exam
        $answers = [
            // Introduction to C (Q1–10)
            1  => 'a', // Dennis Ritchie
            2  => 'c', // .c
            3  => 'd', // <stdio.h>
            4  => 'c', // main()
            5  => 'c', // Successful execution
            6  => 'b', // Newline
            7  => 'c', // Tab
            8  => 'b', // // comment
            9  => 'c', // ;
            10 => 'd', // True (case-sensitive)
            // Data Types & Variables (Q11–20)
            11 => 'c', // int
            12 => 'd', // %d
            13 => 'c', // &
            14 => 'd', // float
            15 => 'b', // Float with 2 decimal places
            16 => 'c', // string
            17 => 'c', // %c
            18 => 'b', // int x = 5;
            19 => 'd', // scanf()
            20 => 'c', // Large decimal numbers
            // If-Else Statements (Q21–30)
            21 => 'b', // ==
            22 => 'c', // AND
            23 => 'b', // OR
            24 => 'c', // if (condition) { }
            25 => 'd', // Not equal to
            26 => 'b', // An if inside another if
            27 => 'c', // Logical NOT
            28 => 'c', // else if
            29 => 'c', // Nothing, continues normally
            30 => 'c', // Greater than or equal to
            // Loops (Q31–40)
            31 => 'c', // for
            32 => 'c', // do-while
            33 => 'c', // break
            34 => 'c', // continue
            35 => 'c', // 5
            36 => 'b', // Nested loop
            37 => 'c', // do-while
            38 => 'd', // Increase i by 1
            39 => 'b', // Star patterns and grids
            40 => 'b', // while (condition) { }
            // Switch Case (Q41–50)
            41 => 'c', // switch
            42 => 'b', // break
            43 => 'b', // No case matches
            44 => 'c', // float
            45 => 'c', // Fall-through to next case
            46 => 'b', // No, optional
            47 => 'c', // Fall-through
            48 => 'c', // long if-else if chains
            49 => 'c', // case 1:
            50 => 'd', // Comparing one variable to many fixed values
        ];

        $score = 0;
        foreach ($answers as $q => $correct) {
            if ($request->input("q$q") == $correct) {
                $score++;
            }
        }

        $total      = 50;
        $percentage = ($score / $total) * 100;
        $passed     = $percentage >= 75; // 75% required to pass

        // Create certificate if user passed
        if ($passed) {
            $username = session('username');
            $user = DB::table('users')->where('username', $username)->first();

            if ($user) {
                // Check if certificate already exists
                $existingCertificate = DB::table('certificates')
                    ->where('user_id', $user->id)
                    ->where('course_name', 'C')
                    ->first();

                if (!$existingCertificate) {
                    DB::table('certificates')->insert([
                        'user_id'      => $user->id,
                        'course_name'  => 'C',
                        'score'        => $score,
                        'percentage'   => $percentage,
                        'passed'       => $passed,
                        'awarded_at'   => now(),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }

            // Update course completion
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'C')
                ->update(['current_lesson' => 7]);
        }

        return redirect()->route('c.course')->with([
            'score'      => $score,
            'total'      => $total,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'c_final',
        ]);
    }
}
