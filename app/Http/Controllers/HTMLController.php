<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HTMLController extends Controller
{
    // =========================================================
    // SHOW HTML COURSE
    // =========================================================
    public function htmlCourse()
    {
        $user = session('username');

        $progress = DB::table('user_progress')
            ->where('username', $user)
            ->where('course_name', 'HTML')
            ->first();

        if (!$progress) {
            DB::table('user_progress')->insert([
                'username'       => $user,
                'course_name'    => 'HTML',
                'current_lesson' => 1
            ]);
            $current_lesson = 1;
        } else {
            $current_lesson = $progress->current_lesson;
        }

        DB::table('user_courses')->updateOrInsert(
            ['username' => $user, 'course_name' => 'HTML']
        );

        $userRecord  = DB::table('users')->where('username', $user)->first();
        $certificate = null;
        if ($userRecord) {
            $certificate = DB::table('certificates')
                ->where('user_id', $userRecord->id)
                ->where('course_name', 'HTML')
                ->first();
        }

        return view('html_course', [
            'current_lesson' => $current_lesson,
            'showQuiz'       => false,
            'certificate'    => $certificate,
        ]);
    }

    // =========================================================
    // LESSON 1
    // =========================================================
    public function htmlQuiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        return view('html_course', [
            'showQuiz'       => true,
            'current_lesson' => $current_lesson,
        ]);
    }

    public function submitQuiz(Request $request)
    {
        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'a') $score++;
        if ($request->q2  == 'a') $score++;
        if ($request->q3  == 'c') $score++;
        if ($request->q4  == 'a') $score++;
        if ($request->q5  == 'd') $score++;
        if ($request->q6  == 'a') $score++;
        if ($request->q7  == 'a') $score++;
        if ($request->q8  == 'a') $score++;
        if ($request->q9  == 'b') $score++;
        if ($request->q10 == 'a') $score++;

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($passed && $progress->current_lesson == 1) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 2]);
        }

        return redirect()->route('html.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'lesson1',
        ]);
    }

    // =========================================================
    // LESSON 2
    // =========================================================
    public function lesson2Quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        if ($current_lesson < 2) {
            return redirect()->route('html.course')->with('error', 'Finish Lesson 1 first!');
        }

        return view('html_course', [
            'showQuiz'       => 'lesson2',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson2Submit(Request $request)
    {
        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'b') $score++;
        if ($request->q2  == 'b') $score++;
        if ($request->q3  == 'b') $score++;
        if ($request->q4  == 'b') $score++;
        if ($request->q5  == 'b') $score++;
        if ($request->q6  == 'b') $score++;
        if ($request->q7  == 'c') $score++;
        if ($request->q8  == 'a') $score++;
        if ($request->q9  == 'b') $score++;
        if ($request->q10 == 'b') $score++;

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($passed && $progress->current_lesson == 2) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 3]);
        }

        return redirect()->route('html.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'lesson2',
        ]);
    }

    // =========================================================
    // LESSON 3
    // =========================================================
    public function lesson3Quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        if ($current_lesson < 3) {
            return redirect()->route('html.course')->with('error', 'Finish Lesson 2 first!');
        }

        return view('html_course', [
            'showQuiz'       => 'lesson3',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson3Submit(Request $request)
    {
        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'a') $score++;
        if ($request->q2  == 'c') $score++;
        if ($request->q3  == 'b') $score++;
        if ($request->q4  == 'c') $score++;
        if ($request->q5  == 'c') $score++;
        if ($request->q6  == 'c') $score++;
        if ($request->q7  == 'b') $score++;
        if ($request->q8  == 'b') $score++;
        if ($request->q9  == 'c') $score++;
        if ($request->q10 == 'b') $score++;

        $percentage = ($score / 10) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($passed && $progress->current_lesson == 3) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 4]);
        }

        return redirect()->route('html.course')->with([
            'score'      => $score,
            'total'      => 10,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'lesson3',
        ]);
    }

    // =========================================================
    // LESSON 4 (Practical — code editor)
    // =========================================================
    public function lesson4Quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        if ($current_lesson < 4) {
            return redirect()->route('html.course');
        }

        return view('html_course', [
            'showQuiz'       => 'lesson4',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function lesson4Pass()
    {
        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($progress && $progress->current_lesson == 4) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 5]);
        }

        return redirect()->route('html.course')->with([
            'passed'     => true,
            'score'      => 1,
            'total'      => 1,
            'percentage' => 100,
            'quiz'       => 'lesson4',
        ]);
    }

    // =========================================================
    // LESSON 5 (10 MCQ questions based on Lesson 5 content)
    // =========================================================
    public function lesson5Quiz()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        if ($current_lesson < 5) {
            return redirect()->route('html.course');
        }

        return view('html_course', [
            'showQuiz'       => 'lesson5',
            'current_lesson' => min($current_lesson, 5), // FIX: prevents blade from skipping to final
        ]);
    }

    public function lesson5Submit(Request $request)
    {
        // Validate 10 questions for Quiz 5
        $request->validate([
            'q1'  => 'required', 'q2'  => 'required', 'q3'  => 'required',
            'q4'  => 'required', 'q5'  => 'required', 'q6'  => 'required',
            'q7'  => 'required', 'q8'  => 'required', 'q9'  => 'required',
            'q10' => 'required',
        ]);

        $score = 0;
        if ($request->q1  == 'c') $score++; // Adding interactivity and dynamic behavior
        if ($request->q2  == 'b') $score++; // <script>
        if ($request->q3  == 'c') $score++; // <script src="script.js"></script>
        if ($request->q4  == 'd') $score++; // document.getElementById()
        if ($request->q5  == 'b') $score++; // document.querySelector()
        if ($request->q6  == 'c') $score++; // innerHTML
        if ($request->q7  == 'b') $score++; // style.color
        if ($request->q8  == 'c') $score++; // onclick
        if ($request->q9  == 'c') $score++; // onclick="myFunc()"
        if ($request->q10 == 'b') $score++; // addEventListener()

        $total      = 10;
        $percentage = ($score / $total) * 100;
        $passed     = $percentage >= 75;

        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($passed && $progress && $progress->current_lesson == 5) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 6]);
        }

        return redirect()->route('html.course')->with([
            'score'      => $score,
            'total'      => $total,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'lesson5',
        ]);
    }

    public function lesson5Pass()
    {
        $progress = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->first();

        if ($progress && $progress->current_lesson == 5) {
            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 6]);
        }

        return redirect()->route('html.course')->with([
            'passed'     => true,
            'score'      => 10,
            'total'      => 10,
            'percentage' => 100,
            'quiz'       => 'lesson5',
        ]);
    }

    // =========================================================
    // FINAL EXAM
    // =========================================================
    public function finalExam()
    {
        $current_lesson = DB::table('user_progress')
            ->where('username', session('username'))
            ->where('course_name', 'HTML')
            ->value('current_lesson');

        if ($current_lesson < 6) {
            return redirect()->route('html.course');
        }

        return view('html_course', [
            'showQuiz'       => 'final',
            'current_lesson' => $current_lesson,
        ]);
    }

    public function finalExamSubmit(Request $request)
    {
        $rules = [];
        for ($i = 1; $i <= 50; $i++) {
            $rules["q$i"] = 'required';
        }
        $request->validate($rules);

        $answers = [
            // HTML (Q1–17)
            1  => 'a', // HyperText Markup Language
            2  => 'a', // <p>
            3  => 'b', // <img>
            4  => 'c', // <a>
            5  => 'c', // <body>
            6  => 'c', // <!-- comment -->
            7  => 'd', // <h1>
            8  => 'b', // <form>
            9  => 'd', // src
            10 => 'c', // <br>
            11 => 'c', // <ul>
            12 => 'b', // <ol>
            13 => 'c', // password
            14 => 'c', // <textarea>
            15 => 'd', // <select>
            16 => 'b', // enctype="multipart/form-data"
            17 => 'd', // POST
            // CSS (Q18–34)
            18 => 'b', // Cascading Style Sheets
            19 => 'c', // Style and design webpages
            20 => 'b', // h1 {color:red;}
            21 => 'c', // Inline
            22 => 'c', // <style>
            23 => 'c', // External CSS
            24 => 'c', // Pixel
            25 => 'd', // em
            26 => 'c', // color
            27 => 'd', // background-color
            28 => 'b', // text-align
            29 => 'c', // transparency
            30 => 'c', // 0 to 1
            31 => 'c', // invisible
            32 => 'b', // fully visible
            33 => 'c', // padding
            34 => 'c', // margin
            // JavaScript (Q35–50)
            35 => 'c', // Interactivity
            36 => 'c', // <script>
            37 => 'b', // onclick
            38 => 'a', // getElementById
            39 => 'a', // Document Object Model
            40 => 'c', // //
            41 => 'a', // var
            42 => 'b', // let
            43 => 'a', // const
            44 => 'a', // alert()
            45 => 'b', // console.log()
            46 => 'c', // ===
            47 => 'a', // function myFunc() {}
            48 => 'c', // break
            49 => 'c', // onchange
            50 => 'a', // <script src="app.js"></script>
        ];

        $score = 0;
        foreach ($answers as $q => $correct) {
            if ($request->input("q$q") == $correct) {
                $score++;
            }
        }

        $total      = 50;
        $percentage = ($score / $total) * 100;
        $passed     = $percentage >= 85;

        if ($passed) {
            $userRecord = DB::table('users')->where('username', session('username'))->first();

            if ($userRecord) {
                $existingCertificate = DB::table('certificates')
                    ->where('user_id', $userRecord->id)
                    ->where('course_name', 'HTML')
                    ->first();

                if (!$existingCertificate) {
                    DB::table('certificates')->insert([
                        'user_id'      => $userRecord->id,
                        'course_name'  => 'HTML',
                        'score'        => $score,
                        'percentage'   => $percentage,
                        'passed'       => $passed,
                        'awarded_at'   => now(),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }

            DB::table('user_progress')
                ->where('username', session('username'))
                ->where('course_name', 'HTML')
                ->update(['current_lesson' => 7]);
        }

        return redirect()->route('html.course')->with([
            'score'      => $score,
            'total'      => $total,
            'percentage' => $percentage,
            'passed'     => $passed,
            'quiz'       => 'final',
        ]);
    }
}
