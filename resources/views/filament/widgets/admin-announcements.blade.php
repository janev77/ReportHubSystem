<x-filament-widgets::widget>
    <x-filament::section heading="Announcements">

        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1.5rem;">

            @forelse ($announcements as $announcement)

                {{-- CARD --}}
                <div style="
                    display:flex; flex-direction:column; justify-content:space-between;
                    border-radius:1rem;
                    border:1px solid #e5e7eb;
                    background:#ffffff;
                    box-shadow:0 1px 4px rgba(0,0,0,.08);
                    padding:1.5rem;
                    transition:box-shadow .2s;
                ">

                    {{-- Top: category + pinned --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem;">
                        <span style="font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">
                            {{ $announcement->category->name ?? 'General' }}
                        </span>

                        @if ($announcement->is_pinned)
                            <span style="font-size:.7rem; font-weight:800; color:#d97706; background:#fef3c7; padding:.25rem .65rem; border-radius:9999px;">
                                📌 Pinned
                            </span>
                        @endif
                    </div>

                    {{-- TITLE --}}
                    <h2 style="font-size:1.35rem; font-weight:800; color:#111827; margin:0 0 .75rem 0; line-height:1.3;">
                        {{ $announcement->title }}
                    </h2>

                    {{-- CONTENT --}}
                    <p style="font-size:.875rem; color:#4b5563; line-height:1.65; margin:0 0 1rem 0; flex:1;">
                        {{ $announcement->content }}
                    </p>

                    {{-- FOOTER --}}
                    <div style="border-top:1px solid #f3f4f6; padding-top:.75rem;">

                        <div style="font-size:.8rem; color:#6b7280;">
                            Created by:
                            <span style="font-weight:600; color:#374151;">{{ $announcement->created_by }}</span>
                        </div>

                        @if ($announcement->expire_at)
                            <div style="margin-top:.35rem; font-size:.85rem; font-weight:700; color:#ef4444;">
                                Expires: {{ $announcement->expire_at->format('M d, Y') }}
                            </div>
                        @endif

                    </div>

                </div>

            @empty
                <p style="grid-column:1/-1; text-align:center; color:#9ca3af; padding:2rem 0;">
                    No announcements found.
                </p>
            @endforelse

        </div>

    </x-filament::section>
</x-filament-widgets::widget>
