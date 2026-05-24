<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JavaController extends Controller
{
    // =========================================================
    // SHOW JAVA COURSE
    // =========================================================
    public function javaCourse()
    {
        $user = session('username');

        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if (!$progress) {
            DB::table('user_progress')->insert([
                'username'       => $user,
                'course_name'    => 'Java',
                'current_lesson' => 1
            ]);
            $current_lesson = 1;
        } else {
            $current_lesson = $progress->current_lesson;
        }

        DB::table('user_courses')->updateOrInsert(
            ['username' => $user, 'course_name' => 'Java']
        );

        // Fetch certificate if user has completed the course
        $userRecord = DB::table('users')->where('username', $user)->first();
        $certificate = null;
        if ($userRecord) {
            $certificate = DB::table('certificates')
                ->where('user_id', $userRecord->id)
                ->where('course_name', 'Java')
                ->first();
        }

        return view('java_course', [
            'current_lesson' => $current_lesson,
            'showQuiz'       => false,
            'certificate'    => $certificate,
        ]);
    }

    // =========================================================
    // LESSON 1 QUIZ
    // =========================================================
    public function javaQuiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        return view('java_course', [
            'showQuiz'       => true,
            'current_lesson' => $current_lesson,
        ]);
    }

    public function submitQuiz(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'b') $score++; // James Gosling
        if ($request->q2  == 'c') $score++; // JVM
        if ($request->q3  == 'd') $score++; // .java
        if ($request->q4  == 'b') $score++; // public static void main
        if ($request->q5  == 'c') $score++; // println
        if ($request->q6  == 'b') $score++; // WORA
        if ($request->q7  == 'c') $score++; // \n
        if ($request->q8  == 'c') $score++; // //
        if ($request->q9  == 'b') $score++; // Object-Oriented
        if ($request->q10 == 'b') $score++; // \t

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if ($passed && $progress->current_lesson == 1) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 2]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_lesson1',
        ]);
    }

    // =========================================================
    // LESSON 2 QUIZ
    // =========================================================
    public function lesson2Quiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        if ($current_lesson < 2) {
            return redirect()->route('java.course')->with('error', 'Finish Lesson 1 first!');
        }

        return view('java_course', [
            'showQuiz'       => 'lesson2',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson2Submit(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'c') $score++; // int
        if ($request->q2  == 'b') $score++; // boolean
        if ($request->q3  == 'c') $score++; // final
        if ($request->q4  == 'c') $score++; // Scanner
        if ($request->q5  == 'd') $score++; // %f
        if ($request->q6  == 'b') $score++; // 3
        if ($request->q7  == 'c') $score++; // String
        if ($request->q8  == 'b') $score++; // .equals()
        if ($request->q9  == 'c') $score++; // nextLine()
        if ($request->q10 == 'b') $score++; // float with 2 decimal places

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if ($passed && $progress->current_lesson == 2) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 3]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_lesson2',
        ]);
    }

    // =========================================================
    // LESSON 3 QUIZ
    // =========================================================
    public function lesson3Quiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        if ($current_lesson < 3) {
            return redirect()->route('java.course')->with('error', 'Finish Lesson 2 first!');
        }

        return view('java_course', [
            'showQuiz'       => 'lesson3',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson3Submit(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'c') $score++; // ==
        if ($request->q2  == 'c') $score++; // AND
        if ($request->q3  == 'd') $score++; // OR
        if ($request->q4  == 'c') $score++; // double
        if ($request->q5  == 'd') $score++; // break
        if ($request->q6  == 'c') $score++; // if (condition)
        if ($request->q7  == 'c') $score++; // Yes
        if ($request->q8  == 'c') $score++; // Not equal to
        if ($request->q9  == 'b') $score++; // No case matches
        if ($request->q10 == 'c') $score++; // Logical NOT

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if ($passed && $progress->current_lesson == 3) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 4]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_lesson3',
        ]);
    }

    // =========================================================
    // LESSON 4 QUIZ
    // =========================================================
    public function lesson4Quiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        if ($current_lesson < 4) {
            return redirect()->route('java.course')->with('error', 'Finish Lesson 3 first!');
        }

        return view('java_course', [
            'showQuiz'       => 'lesson4',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson4Submit(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'c') $score++; // for
        if ($request->q2  == 'c') $score++; // for (init; condition; update)
        if ($request->q3  == 'd') $score++; // break
        if ($request->q4  == 'c') $score++; // continue
        if ($request->q5  == 'c') $score++; // do-while
        if ($request->q6  == 'c') $score++; // 5
        if ($request->q7  == 'b') $score++; // A loop inside another loop
        if ($request->q8  == 'c') $score++; // for-each
        if ($request->q9  == 'd') $score++; // Increase i by 1
        if ($request->q10 == 'a') $score++; // 10 (missing from file, but placeholder)

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if ($passed && $progress->current_lesson == 4) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 5]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_lesson4',
        ]);
    }

    // =========================================================
    // LESSON 5 QUIZ
    // =========================================================
    public function lesson5Quiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        if ($current_lesson < 5) {
            return redirect()->route('java.course')->with('error', 'Finish Lesson 4 first!');
        }

        return view('java_course', [
            'showQuiz'       => 'lesson5',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson5Submit(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'c') $score++; // class is blueprint
        if ($request->q2  == 'b') $score++; // new
        if ($request->q3  == 'c') $score++; // this
        if ($request->q4  == 'c') $score++; // private
        if ($request->q5  == 'c') $score++; // extends
        if ($request->q6  == 'a') $score++; // @Override
        if ($request->q7  == 'c') $score++; // Multiple methods, same name, different params
        if ($request->q8  == 'c') $score++; // Only one
        if ($request->q9  == 'b') $score++; // private fields with getters/setters
        if ($request->q10 == 'b') $score++; // One interface with many implementations

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->first();

        if ($passed && $progress->current_lesson == 5) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 6]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_lesson5',
        ]);
    }

    // =========================================================
    // FINAL EXAM
    // =========================================================
    public function finalExam()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Java')
            ->value('current_lesson');

        if ($current_lesson < 6) {
            return redirect()->route('java.course')->with('error', 'Finish Lesson 5 first!');
        }

        return view('java_course', [
            'showQuiz'       => 'final',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function finalSubmit(Request $request)
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        // Validate all 50 questions
        $rules = [];
        for ($i = 1; $i <= 50; $i++) {
            $rules['q' . $i] = 'required';
        }
        $request->validate($rules);

        $score = 0;

        // Q1-Q10: Introduction to Java
        if ($request->q1  == 'b') $score++; // James Gosling
        if ($request->q2  == 'c') $score++; // JVM
        if ($request->q3  == 'b') $score++; // Java Virtual Machine
        if ($request->q4  == 'c') $score++; // .java
        if ($request->q5  == 'd') $score++; // public static void main(String[] args)
        if ($request->q6  == 'b') $score++; // println
        if ($request->q7  == 'c') $score++; // Newline
        if ($request->q8  == 'b') $score++; // // comment
        if ($request->q9  == 'c') $score++; // Object-Oriented
        if ($request->q10 == 'd') $score++; // Tab space

        // Q11-Q20: Data Types & Variables
        if ($request->q11 == 'c') $score++; // int
        if ($request->q12 == 'c') $score++; // char
        if ($request->q13 == 'b') $score++; // final
        if ($request->q14 == 'c') $score++; // Scanner
        if ($request->q15 == 'b') $score++; // float with 2 decimal places
        if ($request->q16 == 'c') $score++; // String
        if ($request->q17 == 'b') $score++; // 3
        if ($request->q18 == 'b') $score++; // .equals()
        if ($request->q19 == 'd') $score++; // sc.nextLine()
        if ($request->q20 == 'b') $score++; // Integer.parseInt()

        // Q21-Q30: Control Flow
        if ($request->q21 == 'b') $score++; // ==
        if ($request->q22 == 'c') $score++; // AND
        if ($request->q23 == 'b') $score++; // OR
        if ($request->q24 == 'c') $score++; // double
        if ($request->q25 == 'c') $score++; // Not equal to
        if ($request->q26 == 'c') $score++; // break
        if ($request->q27 == 'c') $score++; // Logical NOT
        if ($request->q28 == 'd') $score++; // Minor
        if ($request->q29 == 'c') $score++; // Nothing, program continues
        if ($request->q30 == 'd') $score++; // >=

        // Q31-Q40: Loops
        if ($request->q31 == 'c') $score++; // for
        if ($request->q32 == 'c') $score++; // do-while
        if ($request->q33 == 'c') $score++; // break
        if ($request->q34 == 'c') $score++; // continue
        if ($request->q35 == 'c') $score++; // 5
        if ($request->q36 == 'b') $score++; // Nested loop
        if ($request->q37 == 'c') $score++; // do-while
        if ($request->q38 == 'd') $score++; // Increase i by 1
        if ($request->q39 == 'b') $score++; // Iterating over arrays
        if ($request->q40 == 'c') $score++; // for (int n : nums)

        // Q41-Q50: OOP
        if ($request->q41 == 'c') $score++; // blueprint
        if ($request->q42 == 'b') $score++; // new
        if ($request->q43 == 'c') $score++; // current object instance
        if ($request->q44 == 'c') $score++; // private
        if ($request->q45 == 'c') $score++; // extends
        if ($request->q46 == 'a') $score++; // @Override
        if ($request->q47 == 'c') $score++; // Multiple methods same name different params
        if ($request->q48 == 'c') $score++; // Only one
        if ($request->q49 == 'b') $score++; // private with getters/setters
        if ($request->q50 == 'b') $score++; // One interface many implementations

        $percentage = ($score / 50) * 100;
        $passed     = $percentage >= 80;

        // Create certificate if user passed
        if ($passed) {
            $userRecord = DB::table('users')->where('username', $user)->first();

            if ($userRecord) {
                // Check if certificate already exists
                $existingCertificate = DB::table('certificates')
                    ->where('user_id', $userRecord->id)
                    ->where('course_name', 'Java')
                    ->first();

                if (!$existingCertificate) {
                    DB::table('certificates')->insert([
                        'user_id'      => $userRecord->id,
                        'course_name'  => 'Java',
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
                ->where('username', $user)
                ->where('course_name', 'Java')
                ->update(['current_lesson' => 7]);
        }

        return redirect()->route('java.course')->with([
            'score'      => $score,
            'total'      => 50,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'java_final',
        ]);
    }
}
