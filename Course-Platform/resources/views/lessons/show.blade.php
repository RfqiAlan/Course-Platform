<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl flex flex-col md:flex-row">

                {{-- Sidebar daftar materi --}}
                <aside class="md:w-1/3 border-b md:border-b-0 md:border-r border-gray-100 p-4 max-h-[70vh] overflow-y-auto">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Daftar Materi</h3>
                    <ol class="space-y-1 text-sm">
                        @foreach($contents as $item)
                            @php
                                $isActive = $item->id === $content->id;
                            @endphp
                            <li>
                                <a href="{{ route('lessons.show', [$course->id, $item->id]) }}"
                                   class="flex items-center gap-2 px-2 py-1 rounded-lg
                                        {{ $isActive ? 'bg-blue-50 text-blue-700 font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                    <span class="text-xs text-gray-400 w-5">{{ $item->order }}.</span>
                                    <span class="flex-1 line-clamp-1">
                                        {{ $item->title }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </aside>

                {{-- Konten materi --}}
                <main class="md:w-2/3 p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">
                            Materi {{ $content->order }} dari {{ $contents->count() }}
                        </p>
                        <h1 class="text-xl font-bold text-gray-900">
                            {{ $content->title }}
                        </h1>
                    </div>

                    <div class="prose prose-sm max-w-none">
                        {!! $content->body !!}
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <form method="POST" action="{{ route('lessons.mark-done', $content) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-lg
                                           {{ $done ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }}">
                                {{ $done ? 'Tandai & Lanjutkan / Ulangi' : 'Tandai Selesai & Lanjutkan' }}
                            </button>
                        </form>

                        <a href="{{ route('dashboard') }}"
                           class="text-xs text-gray-500 hover:underline">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
