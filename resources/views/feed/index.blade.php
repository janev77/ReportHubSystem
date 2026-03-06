<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <span class="font-bold text-lg">ReportHubSystem</span>
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-600">{{ auth()->user()->email }}</span>
        <form method="POST" action="/logout">
            @csrf
            <button class="text-sm text-red-500 hover:underline">Одјави се</button>
        </form>
    </div>
</nav>

<div class="max-w-3xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-6">Известувања</h1>

    @forelse ($announcements as $announcement)
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold uppercase tracking-wide
                        {{ $announcement->status === 'important' ? 'text-red-500' : 'text-gray-400' }}">
{{--                        {{ $announcement->status ?? 'General' }}--}}
                        {{ $announcement->category->name ?? '-' }}
                    </span>
                @if ($announcement->is_pinned)
                    <span class="text-xs text-yellow-500 font-semibold">Pinned</span>
                @endif
            </div>
            <h2 class="text-lg font-semibold mb-1">{{ $announcement->title }}</h2>
            <p class="text-gray-600 text-sm mb-3">{{ $announcement->content }}</p>
            <div class="text-xs text-gray-400 flex gap-4">
                <span>Објавено од:</span>
                <span>{{ $announcement->created_by }}</span>
                @if ($announcement->expire_at)
                    <span>Истекува на: {{ $announcement->expire_at->format('M d, Y') }}</span>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-500">Нема достапни известувања.</p>
    @endforelse

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</div>

</body>
</html>
