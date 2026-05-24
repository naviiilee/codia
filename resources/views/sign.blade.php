<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup - C0DiA</title>
<link rel="stylesheet" href="sign.css">
</head>
<body>

<div class="signup-wrapper">

    <!-- Motivation -->
    <div class="motivation">
        <h2>Let's see our potential! 🚀</h2>
        <p>Start your coding journey and become the developer you’ve always wanted to be.</p>
    </div>

    <!-- Signup Form -->
    <form action="{{ route('signup.post') }}" method="POST" class="signup-form">
    @csrf

        <h1>Create Your Account</h1>

        <div class="box">
            <input type="text" name="first" placeholder="First Name" maxlength="50" required>
        </div>

        <div class="box">
            <input type="text" name="last" placeholder="Last Name" maxlength="50" required>
        </div>

        <div class="box">
            <input type="text" name="username" placeholder="Username" maxlength="30" required>
        </div>

        <div class="box">
            <input type="email" name="email" placeholder="Email" maxlength="100" required>
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
