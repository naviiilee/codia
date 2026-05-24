{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA</title>
    <link rel="stylesheet" href="{{ asset('index.css') }}">
</head>
<body>

<div class="main">

    <div class="welcome">

        <p class="hello">Hello World!</p>

        <h1>Welcome to C0DiA 👋</h1>

        <p class="tagline">
            Learn. Build. Become a Developer.
        </p>

        <p class="motivation">
            Every great programmer started with a single line of code.
            Let's discover our potential and unlock what we are capable of.
        </p>

        <p class="motivation2">
            Here in C0DiA, you can learn, socialize, and interact with the pros.
        </p>

        <p class="start">
            Your coding journey starts today. 🚀
        </p>

    </div> <!-- end welcome -->

    <div class="login">

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <h2>Login to Continue</h2>

            {{-- SESSION error message --}}
            @if(session('error'))
                <div id="error-message" style="color:#ff6b6b; font-size:14px; margin-top:10px;">
                    {{ session('error') }}
                </div>
            @else
                <div id="error-message" style="color:#ff6b6b; font-size:14px; margin-top:10px;"></div>
            @endif

            <div class="box">
                <input type="text" name="username" placeholder="Username or Email" required>
            </div>

            <div class="box">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <div style="margin-top:5px;">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>

            <div class="options">

                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <div class="forgot">
                    <a href="#">Forgot Password?</a>
                </div>

            </div>

            <div class="btn">
                <button type="submit">Login</button>
            </div>

            <div class="create">
                <button type="button" onclick="location.href='{{ route('signup') }}'">Create Account</button>
            </div>

        </form>

    </div> <!-- end login -->

</div> <!-- end main -->

<script>
    // Show/hide password toggle
    const toggle = document.getElementById("showPassword");
    const password = document.getElementById("password");

    toggle.addEventListener("change", function(){
        if(this.checked){
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
</script>

</body>
</html>
