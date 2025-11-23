<x-app-layout title="Chat dengan {{ $teacher->name }}">
    <div class="container py-4">

        {{-- Header --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Chat dengan {{ $teacher->name }}</h1>
                <p class="small text-muted mb-0">Mulai percakapan dengan gurumu.</p>
            </div>
        </div>

        {{-- Wrapper Chat --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0" style="height: 65vh; display: flex; flex-direction: column;">

                {{-- CHAT AREA --}}
                <div id="chat-box"
                    class="p-3 overflow-auto flex-grow-1"
                    style="background: #f9fafb; border-bottom: 1px solid #eee;">

                    @forelse ($messages as $msg)
                        @php
                            $isMine = $msg->sender_id == auth()->id();
                        @endphp

                        {{-- Bubble pesan --}}
                        <div class="mb-3 d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="px-3 py-2 rounded-3"
                                style="
                                    max-width: 70%;
                                    background: {{ $isMine ? '#4f46e5' : '#e5e7eb' }};
                                    color: {{ $isMine ? 'white' : '#111827' }};
                                ">

                                {{-- Nama sender --}}
                                <small class="fw-bold d-block mb-1" style="opacity: .85;">
                                    {{ $msg->sender->name }}
                                </small>

                                {{-- Pesan --}}
                                <span class="small d-block">
                                    {{ $msg->message }}
                                </span>

                                {{-- Timestamp --}}
                                <small class="d-block text-end mt-1" style="opacity: .6; font-size: 10px;">
                                    {{ $msg->created_at->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted small my-5">Belum ada pesan.</p>
                    @endforelse
                </div>

                {{-- FORM INPUT PESAN --}}
                <form action="{{ route('student.chat.store', $thread) }}" method="POST"
                      class="d-flex p-3 gap-2 border-top">

                    @csrf

                    <input type="text" name="message"
                           class="form-control rounded-pill"
                           placeholder="Tulis pesan..."
                           required>

                    <button class="btn btn-primary rounded-pill px-4">
                        Kirim
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- Auto scroll ke bawah --}}
    <script>
        setTimeout(() => {
            const box = document.getElementById('chat-box');
            box.scrollTop = box.scrollHeight;
        }, 300);
    </script>
</x-app-layout>
