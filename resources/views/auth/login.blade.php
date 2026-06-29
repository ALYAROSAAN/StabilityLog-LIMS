<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - StabilityLog LIMS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; font-family: sans-serif;">

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="margin-bottom: 1.5rem; text-align: center; color: #1f2937;">StabilityLog LIMS</h2>
        
        @if ($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.875rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; color: #4b5563;">Email Pengguna</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #4b5563;">Kata Sandi</label>
                <input type="password" name="password" id="password" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
            </div>

            <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Masuk ke Sistem</button>
        </form>
    </div>

</body>
</html>