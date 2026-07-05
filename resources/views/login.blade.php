<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-[400px] px-5">
        <div class="bg-white border border-[#bbb] p-8 text-center">
            <img src="{{ asset('images/army.png.png') }}" alt="Logo" class="block w-[100px] h-auto mx-auto mb-5 object-contain">

            @if ($errors->any())
                <div class="bg-[#f8d7da] text-black px-3.5 py-2 text-sm mb-4 border border-[#f5c6cb] text-left">{{ $errors->first() }}</div>
            @endif

            <div id="jsError" class="bg-[#f8d7da] text-black px-3.5 py-2 text-sm mb-4 border border-[#f5c6cb] text-left hidden"></div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 text-left">
                    <label for="email" class="block text-xs font-bold text-black mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 bg-white border border-[#aaa] text-black text-sm outline-none focus:border-[#003366]">
                </div>

                <div class="mb-4 text-left">
                    <label for="password" class="block text-xs font-bold text-black mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 bg-white border border-[#aaa] text-black text-sm outline-none focus:border-[#003366]">
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#003366] text-white text-sm font-bold border border-[#002244] cursor-pointer">Sign In</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
