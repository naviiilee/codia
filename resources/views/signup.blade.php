{{-- resources/views/signup.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup - C0DiA</title>
<link rel="stylesheet" href="{{ asset('sign.css') }}">
</head>
<body>

<div class="signup-wrapper">
    <div class="motivation">
        <h2>Let's see our potential! 🚀</h2>
        <p>Start your coding journey and become the developer you’ve always wanted to be.</p>
    </div>

    <form action="{{ route('signup.post') }}" method="POST" class="signup-form">
        @csrf
        <h1>Create Your Account</h1>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div style="color:#ff6b6b; font-size:14px; margin-bottom:10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="box">
            <input type="text" name="first" placeholder="First Name" maxlength="50" value="{{ old('first') }}" required>
        </div>
        <div class="box">
            <input type="text" name="last" placeholder="Last Name" maxlength="50" value="{{ old('last') }}" required>
        </div>
        <div class="box">
            <input type="text" name="username" placeholder="Username" maxlength="30" value="{{ old('username') }}" required>
        </div>
        <div class="box">
            <input type="email" name="email" placeholder="Email" maxlength="100" value="{{ old('email') }}" required>
        </div>
        <div class="box">
            <input type="password" name="password" placeholder="Password" maxlength="8" required>
        </div>
        <div class="box">
            <input type="password" name="confirm_password" placeholder="Confirm Password" maxlength="8" required>
        </div>

        <div class="btn">
            <button type="submit">Sign Up</button>
        </div>

        <div class="create">
            <a href="{{ route('home') }}" class="create-btn">Already have an account? Login</a>
        </div>
    </form>
</div>

</body>
</html>
