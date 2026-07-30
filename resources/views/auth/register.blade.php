<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Flavours</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f2ffe9; min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .register-card { background: white; padding: 40px; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #111827; font-size: 28px; margin-bottom: 8px; font-weight: bold; }
        p { color: #6b7280; font-size: 14px; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        input { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 14px; outline: none; }
        input:focus { border-color: #5ce625; }
        .btn-submit { width: 100%; background-color: #5ce625; color: #111827; border: none; padding: 14px; border-radius: 50px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; transition: background 0.2s; }
        .btn-submit:hover { background-color: #49c21a; }
        .switch-text { text-align: center; margin-top: 20px; font-size: 14px; color: #4b5563; }
        .switch-text a { color: #2d7a10; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <div class="register-card">
        <h2>Create Account</h2>
        <p>Join Flavours today</p>

            <form action="{{ route('register') }}" method="POST">


            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="your name">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="name@gmail.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Register</button>
        </form>

        <div class="switch-text">
            Already have an account? <a href="/login">Login here</a>
        </div>
    </div>

</body>
</html>
