<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PythonController extends Controller
{
    // =========================================================
    // SHOW PYTHON COURSE
    // =========================================================
    public function pythonCourse()
    {
        $user = session('username');

        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if (!$progress) {
            DB::table('user_progress')->insert([
                'username'       => $user,
                'course_name'    => 'Python',
                'current_lesson' => 1
            ]);
            $current_lesson = 1;
        } else {
            $current_lesson = $progress->current_lesson;
        }

        DB::table('user_courses')->updateOrInsert(
            ['username' => $user, 'course_name' => 'Python']
        );

        // Fetch certificate if user has completed the course
        $userRecord = DB::table('users')->where('username', $user)->first();
        $certificate = null;
        if ($userRecord) {
            $certificate = DB::table('certificates')
                ->where('user_id', $userRecord->id)
                ->where('course_name', 'Python')
                ->first();
        }

        return view('python_course', [
            'current_lesson' => $current_lesson,
            'showQuiz'       => false,
            'certificate'    => $certificate,
        ]);
    }

    // =========================================================
    // LESSON 1 QUIZ
    // =========================================================
    public function pyQuiz()
    {
        $user = session('username');
        if (!$user) {
            return redirect()->route('home')->with('error', 'Please login first');
        }

        $current_lesson = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->value('current_lesson');

        return view('python_course', [
            'showQuiz'       => true,
            'current_lesson' => $current_lesson,
        ]);
    }

    public function pySubmit(Request $request)
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
        if ($request->q1  == 'b') $score++; // Guido van Rossum
        if ($request->q2  == 'c') $score++; // 1991
        if ($request->q3  == 'd') $score++; // print
        if ($request->q4  == 'c') $score++; // Using indentation
        if ($request->q5  == 'c') $score++; // # comment
        if ($request->q6  == 'c') $score++; // Python 3
        if ($request->q7  == 'b') $score++; // \n
        if ($request->q8  == 'b') $score++; // Dynamically typed
        if ($request->q9  == 'c') $score++; // .py
        if ($request->q10 == 'b') $score++; // print("\t")

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if ($passed && $progress->current_lesson == 1) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 2]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_lesson1',
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
            ->where('course_name', 'Python')
            ->value('current_lesson');

        if ($current_lesson < 2) {
            return redirect()->route('py.course')->with('error', 'Finish Lesson 1 first!');
        }

        return view('python_course', [
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
        if ($request->q1  == 'd') $score++; // input()
        if ($request->q2  == 'c') $score++; // str
        if ($request->q3  == 'c') $score++; // bool
        if ($request->q4  == 'c') $score++; // <class 'float'>
        if ($request->q5  == 'b') $score++; // f"Hello, {name}"
        if ($request->q6  == 'c') $score++; // snake_case
        if ($request->q7  == 'c') $score++; // int("42")
        if ($request->q8  == 'b') $score++; // False
        if ($request->q9  == 'c') $score++; // s.upper()
        if ($request->q10 == 'c') $score++; // True and False (capitalized)

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if ($passed && $progress->current_lesson == 2) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 3]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_lesson2',
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
            ->where('course_name', 'Python')
            ->value('current_lesson');

        if ($current_lesson < 3) {
            return redirect()->route('py.course')->with('error', 'Finish Lesson 2 first!');
        }

        return view('python_course', [
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
        if ($request->q1  == 'c') $score++; // elif
        if ($request->q2  == 'b') $score++; // 0, 1, 2, 3, 4
        if ($request->q3  == 'c') $score++; // break
        if ($request->q4  == 'c') $score++; // continue
        if ($request->q5  == 'b') $score++; // Both conditions to be True
        if ($request->q6  == 'c') $score++; // 1, 3, 5, 7, 9
        if ($request->q7  == 'c') $score++; // "Adult" if age >= 18 else "Minor"
        if ($request->q8  == 'b') $score++; // print(value, end="")
        if ($request->q9  == 'c') $score++; // Python 3.10
        if ($request->q10 == 'c') $score++; // Reverses a boolean condition

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if ($passed && $progress->current_lesson == 3) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 4]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_lesson3',
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
            ->where('course_name', 'Python')
            ->value('current_lesson');

        if ($current_lesson < 4) {
            return redirect()->route('py.course')->with('error', 'Finish Lesson 3 first!');
        }

        return view('python_course', [
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
        if ($request->q1  == 'c') $score++; // def
        if ($request->q2  == 'd') $score++; // tuple
        if ($request->q3  == 'c') $score++; // list.append()
        if ($request->q4  == 'b') $score++; // Any number of positional arguments
        if ($request->q5  == 'b') $score++; // A concise way to create a list using a for loop in one line
        if ($request->q6  == 'd') $score++; // dict
        if ($request->q7  == 'c') $score++; // [1, 4, 9]
        if ($request->q8  == 'c') $score++; // Duplicate values
        if ($request->q9  == 'c') $score++; // "default"
        if ($request->q10 == 'b') $score++; // Any number of keyword arguments

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if ($passed && $progress->current_lesson == 4) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 5]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_lesson4',
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
            ->where('course_name', 'Python')
            ->value('current_lesson');

        if ($current_lesson < 5) {
            return redirect()->route('py.course')->with('error', 'Finish Lesson 4 first!');
        }

        return view('python_course', [
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
        if ($request->q1  == 'b') $score++; // class
        if ($request->q2  == 'c') $score++; // __init__
        if ($request->q3  == 'b') $score++; // The current object instance
        if ($request->q4  == 'b') $score++; // Double underscore prefix: __name
        if ($request->q5  == 'c') $score++; // class Dog(Animal):
        if ($request->q6  == 'b') $score++; // super().__init__()
        if ($request->q7  == 'c') $score++; // from abc import ABC, abstractmethod
        if ($request->q8  == 'b') $score++; // Defining how the object is represented as a string (called by print())
        if ($request->q9  == 'b') $score++; // class Duck(Flyable, Swimmable):
        if ($request->q10 == 'c') $score++; // @property

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'Python')
            ->first();

        if ($passed && $progress->current_lesson == 5) {
            DB::table('user_progress')
                ->where('username', $user)
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 6]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_lesson5',
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
            ->where('course_name', 'Python')
            ->value('current_lesson');

        if ($current_lesson < 6) {
            return redirect()->route('py.course')->with('error', 'Finish Lesson 5 first!');
        }

        return view('python_course', [
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

        // Q1-Q10: Introduction to Python
        if ($request->q1  == 'b') $score++; // Guido van Rossum
        if ($request->q2  == 'b') $score++; // 1991
        if ($request->q3  == 'c') $score++; // print
        if ($request->q4  == 'b') $score++; // Using indentation
        if ($request->q5  == 'c') $score++; // # comment
        if ($request->q6  == 'c') $score++; // Python 3
        if ($request->q7  == 'd') $score++; // \n
        if ($request->q8  == 'b') $score++; // Dynamically typed
        if ($request->q9  == 'c') $score++; // .py
        if ($request->q10 == 'b') $score++; // print("\t")

        // Q11-Q20: Variables, Data Types & Input
        if ($request->q11 == 'c') $score++; // input()
        if ($request->q12 == 'c') $score++; // str
        if ($request->q13 == 'c') $score++; // bool
        if ($request->q14 == 'c') $score++; // <class 'float'>
        if ($request->q15 == 'b') $score++; // f"Hello, {name}"
        if ($request->q16 == 'c') $score++; // snake_case
        if ($request->q17 == 'c') $score++; // int("42")
        if ($request->q18 == 'b') $score++; // False
        if ($request->q19 == 'c') $score++; // s.upper()
        if ($request->q20 == 'c') $score++; // True and False (capitalized)

        // Q21-Q30: Control Flow & Loops
        if ($request->q21 == 'c') $score++; // elif
        if ($request->q22 == 'b') $score++; // 0, 1, 2, 3, 4
        if ($request->q23 == 'c') $score++; // break
        if ($request->q24 == 'c') $score++; // continue
        if ($request->q25 == 'c') $score++; // 1, 3, 5, 7, 9
        if ($request->q26 == 'b') $score++; // Both conditions to be True
        if ($request->q27 == 'b') $score++; // "Adult" if age >= 18 else "Minor"
        if ($request->q28 == 'c') $score++; // print(value, end="")
        if ($request->q29 == 'c') $score++; // Python 3.10
        if ($request->q30 == 'c') $score++; // Reverses a boolean condition

        // Q31-Q40: Functions & Collections
        if ($request->q31 == 'c') $score++; // def
        if ($request->q32 == 'c') $score++; // tuple
        if ($request->q33 == 'c') $score++; // list.append()
        if ($request->q34 == 'b') $score++; // Any number of positional arguments
        if ($request->q35 == 'c') $score++; // [1, 4, 9]
        if ($request->q36 == 'd') $score++; // dict
        if ($request->q37 == 'c') $score++; // Duplicate values
        if ($request->q38 == 'c') $score++; // "default"
        if ($request->q39 == 'b') $score++; // Any number of keyword arguments
        if ($request->q40 == 'c') $score++; // a & b (intersection)

        // Q41-Q50: Object-Oriented Programming
        if ($request->q41 == 'b') $score++; // class
        if ($request->q42 == 'c') $score++; // __init__
        if ($request->q43 == 'b') $score++; // The current object instance
        if ($request->q44 == 'b') $score++; // Double underscore prefix: __name
        if ($request->q45 == 'c') $score++; // class Dog(Animal):
        if ($request->q46 == 'b') $score++; // super().__init__()
        if ($request->q47 == 'c') $score++; // from abc import ABC, abstractmethod
        if ($request->q48 == 'b') $score++; // Defining the string representation of an object
        if ($request->q49 == 'b') $score++; // class Duck(Flyable, Swimmable):
        if ($request->q50 == 'c') $score++; // @property

        $percentage = ($score / 50) * 100;
        $passed     = $percentage >= 80;

        // Create certificate if user passed
        if ($passed) {
            $userRecord = DB::table('users')->where('username', $user)->first();

            if ($userRecord) {
                // Check if certificate already exists
                $existingCertificate = DB::table('certificates')
                    ->where('user_id', $userRecord->id)
                    ->where('course_name', 'Python')
                    ->first();

                if (!$existingCertificate) {
                    DB::table('certificates')->insert([
                        'user_id'      => $userRecord->id,
                        'course_name'  => 'Python',
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
                ->where('course_name', 'Python')
                ->update(['current_lesson' => 7]);
        }

        return redirect()->route('py.course')->with([
            'score'      => $score,
            'total'      => 50,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'py_final',
        ]);
    }
}
