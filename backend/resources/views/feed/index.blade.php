<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<!-- NAVBAR -->
<nav class="bg-white shadow px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">

    <span class="font-bold text-lg text-center sm:text-left">
        ReportHubSystem
    </span>

    <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-center sm:text-right">
        <span class="text-sm text-gray-600 break-all">
            {{ auth()->user()->email }}
        </span>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-sm text-red-500 hover:underline">
                Одјави се
            </button>
        </form>
    </div>

</nav>


<!-- CONTENT -->
<div class="max-w-3xl mx-auto py-8 sm:py-10 px-4">

    <h1 class="text-xl sm:text-2xl font-bold mb-6">
        Известувања
    </h1>

    @forelse ($announcements as $announcement)

        <div class="bg-white rounded-xl shadow p-4 sm:p-6 mb-4">

            <!-- STATUS -->
            <div class="flex items-center justify-between mb-2 flex-wrap gap-2">

                <span class="text-xs font-semibold uppercase tracking-wide
                    {{ $announcement->status === 'important' ? 'text-red-500' : 'text-gray-400' }}">
                    {{ $announcement->category->name ?? '-' }}
                </span>

                @if ($announcement->is_pinned)
                    <span class="text-xs text-yellow-500 font-semibold">
                        📌 Pinned
                    </span>
                @endif

            </div>

            <!-- TITLE -->
            <h2 class="text-base sm:text-lg font-semibold mb-1">
                {{ $announcement->title }}
            </h2>

            <!-- CONTENT -->
            <p class="text-gray-600 text-sm mb-3">
                {{ $announcement->content }}
            </p>

            <!-- META -->
            <div class="text-xs text-gray-400 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">

                <span>
                    Објавено од:
                    <span class="font-medium">{{ $announcement->created_by }}</span>
                </span>

                @if ($announcement->expire_at)
                    <span>
                        Истекува на:
                        {{ $announcement->expire_at->format('M d, Y') }}
                    </span>
                @endif

            </div>

        </div>

    @empty
        <p class="text-gray-500 text-center">
            Нема достапни известувања.
        </p>
    @endforelse


    <!-- PAGINATION -->
    <div class="mt-6 flex justify-center">
        {{ $announcements->links() }}
    </div>

</div>

</body>
</html>
