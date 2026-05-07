<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ReportHubSystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-xl shadow p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">ReportHubSystem</h1>

    @if ($errors->any())
        <div class="bg-red-50 text-red-500 text-sm p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                   required autofocus>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                   required>
        </div>
        <button type="submit"
                class="w-full bg-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700">
            Sign In
        </button>
    </form>
</div>
</body>
</html>
