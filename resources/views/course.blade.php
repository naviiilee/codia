@php
    use Illuminate\Support\Facades\DB;

    $user = session('username'); // get logged-in username

    // get courses if needed (optional, depends on your design)
    $courses = DB::table('user_courses')->where('username', $user)->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA Courses</title>
    <link rel="stylesheet" href="{{ asset('course.css') }}">

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('dashboard') }}">🏠 Home</a>
        <a href="{{ route('profile') }}">👤 Profile</a>
        <a href="{{ route('course') }}">📚 Courses</a>
        <a href="{{ route('certificate.show') }}">🏆 Certificates</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="header">📚 Courses</div>

        <div class="container">

            <div class="course-grid">

                <div class="course-card">
                    <h3>C Programming</h3>
                    <p>Learn the fundamentals of C and low-level programming.</p>
                    <a href="{{ route('c.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>C++ Programming</h3>
                    <p>Master object-oriented programming with C++.</p>
                    <a href="{{ route('cpp.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Java Programming</h3>
                    <p>Build powerful applications using Java.</p>
                    <a href="{{ route('java.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Python Programming</h3>
                    <p>Explore Python for web, data science, and more.</p>
                    <a href="{{ route('py.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Web Development</h3>
                    <p>Learn HTML, CSS, and JavaScript to build websites.</p>
                    <a href="{{ route('html.course') }}" class="enroll-btn">Enroll Now</a>
                </div>
            </div>

        </div>

    </div>

</body>

</html>
