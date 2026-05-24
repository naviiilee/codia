<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CppController extends Controller
{
    // =========================================================
    // SHOW C++ COURSE
    // =========================================================
    public function cppCourse()
    {
        $user = session('username');

        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if (!$progress) {
            DB::table('user_progress')->insert([
                'username'       => $user,
                'course_name'    => 'C++',
                'current_lesson' => 1
            ]);
            $current_lesson = 1;
        } else {
            $current_lesson = $progress->current_lesson;
        }

        DB::table('user_courses')->updateOrInsert(
            ['username' => $user, 'course_name' => 'C++']
        );

        // Fetch certificate if user has completed the course
        $userRecord = DB::table('users')->where('username', $user)->first();
        $certificate = null;
        if ($userRecord) {
            $certificate = DB::table('certificates')
                ->where('user_id', $userRecord->id)
                ->where('course_name', 'C++')
                ->first();
        }

        return view('cpp_course', [
            'current_lesson' => $current_lesson,
            'showQuiz'       => false,
            'certificate'    => $certificate,
        ]);
    }

    // =========================================================
    // LESSON 1 QUIZ
    // =========================================================
    public function cppQuiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->value('current_lesson');

        return view('cpp_course', [
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
        if ($request->q1  == 'c') $score++; // Bjarne Stroustrup
        if ($request->q2  == 'b') $score++; // Includes iostream
        if ($request->q3  == 'c') $score++; // cout
        if ($request->q4  == 'b') $score++; // <<
        if ($request->q5  == 'c') $score++; // Allows using standard library names without std::
        if ($request->q6  == 'b') $score++; // Adds a new line
        if ($request->q7  == 'c') $score++; // .cpp
        if ($request->q8  == 'b') $score++; // // comment
        if ($request->q9  == 'c') $score++; // The program ended successfully
        if ($request->q10 == 'c') $score++; // C

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if ($passed && $progress->current_lesson == 1) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 2]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_lesson1',
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
            ->where('course_name', 'C++')
            ->value('current_lesson');

        if ($current_lesson < 2) {
            return redirect()->route('cpp.course')->with('error', 'Finish Lesson 1 first!');
        }

        return view('cpp_course', [
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
        if ($request->q1  == 'c') $score++; // bool
        if ($request->q2  == 'c') $score++; // cin
        if ($request->q3  == 'd') $score++; // >>
        if ($request->q4  == 'c') $score++; // const
        if ($request->q5  == 'c') $score++; // getline(cin, str)
        if ($request->q6  == 'c') $score++; // real
        if ($request->q7  == 'b') $score++; // 3
        if ($request->q8  == 'c') $score++; // auto
        if ($request->q9  == 'c') $score++; // stoi("42")
        if ($request->q10 == 'b') $score++; // to_string(100)

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if ($passed && $progress->current_lesson == 2) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 3]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_lesson2',
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
            ->where('course_name', 'C++')
            ->value('current_lesson');

        if ($current_lesson < 3) {
            return redirect()->route('cpp.course')->with('error', 'Finish Lesson 2 first!');
        }

        return view('cpp_course', [
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
        if ($request->q3  == 'b') $score++; // OR
        if ($request->q4  == 'c') $score++; // double
        if ($request->q5 == 'c') $score++; // break
        if ($request->q6  == 'c') $score++; // Yes
        if ($request->q7  == 'c') $score++; // Not equal to
        if ($request->q8  == 'b') $score++; // No case matches
        if ($request->q9  == 'c') $score++; // Logical NOT
        if ($request->q10 == 'c') $score++; // ==

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if ($passed && $progress->current_lesson == 3) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 4]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_lesson3',
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
            ->where('course_name', 'C++')
            ->value('current_lesson');

        if ($current_lesson < 4) {
            return redirect()->route('cpp.course')->with('error', 'Finish Lesson 3 first!');
        }

        return view('cpp_course', [
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
        if ($request->q8  == 'c') $score++; // for (int n : nums)
        if ($request->q9  == 'd') $score++; // Increase i by 1
        if ($request->q10 == 'c') $score++; // C++11

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if ($passed && $progress->current_lesson == 4) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 5]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_lesson4',
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
            ->where('course_name', 'C++')
            ->value('current_lesson');

        if ($current_lesson < 5) {
            return redirect()->route('cpp.course')->with('error', 'Finish Lesson 4 first!');
        }

        return view('cpp_course', [
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
        if ($request->q1  == 'c') $score++; // class
        if ($request->q2  == 'c') $score++; // private
        if ($request->q3  == 'b') $score++; // A method called automatically when an object is destroyed
        if ($request->q4  == 'c') $score++; // virtual
        if ($request->q5  == 'd') $score++; // : public
        if ($request->q6  == 'b') $score++; // Verifies the method overrides a virtual function
        if ($request->q7  == 'b') $score++; // Having at least one pure virtual function (= 0)
        if ($request->q8  == 'c') $score++; // Multiple inheritance
        if ($request->q9  == 'b') $score++; // The current object instance
        if ($request->q10 == 'b') $score++; // Making members private and providing public getters/setters

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'C++')
            ->first();

        if ($passed && $progress->current_lesson == 5) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 6]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_lesson5',
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
            ->where('course_name', 'C++')
            ->value('current_lesson');

        if ($current_lesson < 6) {
            return redirect()->route('cpp.course')->with('error', 'Finish Lesson 5 first!');
        }

        return view('cpp_course', [
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

        // Q1-Q10: Introduction to C++
        if ($request->q1  == 'c') $score++; // Bjarne Stroustrup
        if ($request->q2  == 'b') $score++; // 1983
        if ($request->q3  == 'b') $score++; // Includes iostream
        if ($request->q4  == 'c') $score++; // cout
        if ($request->q5  == 'b') $score++; // <<
        if ($request->q6  == 'b') $score++; // Allows using standard names without std::
        if ($request->q7  == 'c') $score++; // Moves to next line and flushes the buffer
        if ($request->q8  == 'c') $score++; // .cpp
        if ($request->q9  == 'c') $score++; // Program ended successfully
        if ($request->q10 == 'c') $score++; // C

        // Q11-Q20: Data Types & Variables
        if ($request->q11 == 'c') $score++; // bool
        if ($request->q12 == 'c') $score++; // cin
        if ($request->q13 == 'c') $score++; // const
        if ($request->q14 == 'c') $score++; // getline(cin, str)
        if ($request->q15 == 'b') $score++; // 3
        if ($request->q16 == 'c') $score++; // real
        if ($request->q17 == 'c') $score++; // auto
        if ($request->q18 == 'c') $score++; // stoi("42")
        if ($request->q19 == 'b') $score++; // to_string(100)
        if ($request->q20 == 'c') $score++; // >>

        // Q21-Q30: Control Flow
        if ($request->q21 == 'b') $score++; // ==
        if ($request->q22 == 'c') $score++; // AND
        if ($request->q23 == 'b') $score++; // OR
        if ($request->q24 == 'c') $score++; // double
        if ($request->q25 == 'c') $score++; // Not equal to
        if ($request->q26 == 'c') $score++; // break
        if ($request->q27 == 'c') $score++; // Logical NOT
        if ($request->q28 == 'c') $score++; // Yes
        if ($request->q29 == 'c') $score++; // Nothing, program continues
        if ($request->q30 == 'c') $score++; // ==

        // Q31-Q40: Loops
        if ($request->q31 == 'c') $score++; // for
        if ($request->q32 == 'c') $score++; // do-while
        if ($request->q33 == 'c') $score++; // break
        if ($request->q34 == 'c') $score++; // continue
        if ($request->q35 == 'c') $score++; // 5
        if ($request->q36 == 'b') $score++; // Nested loop
        if ($request->q37 == 'c') $score++; // do-while
        if ($request->q38 == 'd') $score++; // Increase i by 1
        if ($request->q39 == 'c') $score++; // C++11
        if ($request->q40 == 'c') $score++; // for (int n : nums)

        // Q41-Q50: OOP
        if ($request->q41 == 'c') $score++; // class
        if ($request->q42 == 'c') $score++; // private
        if ($request->q43 == 'b') $score++; // A method called automatically when an object is destroyed
        if ($request->q44 == 'c') $score++; // virtual
        if ($request->q45 == 'c') $score++; // class Dog : public Animal
        if ($request->q46 == 'b') $score++; // Verifies the method overrides a virtual function
        if ($request->q47 == 'b') $score++; // Having at least one pure virtual function (= 0)
        if ($request->q48 == 'c') $score++; // Multiple inheritance
        if ($request->q49 == 'b') $score++; // The current object instance
        if ($request->q50 == 'd') $score++; // The current object instance

        $percentage = ($score / 50) * 100;
        $passed     = $percentage >= 75;

        // Create certificate if user passed
        if ($passed) {
            $userRecord = DB::table('users')->where('username', $user)->first();

            if ($userRecord) {
                // Check if certificate already exists
                $existingCertificate = DB::table('certificates')
                    ->where('user_id', $userRecord->id)
                    ->where('course_name', 'C++')
                    ->first();

                if (!$existingCertificate) {
                    DB::table('certificates')->insert([
                        'user_id'      => $userRecord->id,
                        'course_name'  => 'C++',
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
                ->where('course_name', 'C++')
                ->update(['current_lesson' => 7]);
        }

        return redirect()->route('cpp.course')->with([
            'score'      => $score,
            'total'      => 50,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'cpp_final',
        ]);
    }
}
