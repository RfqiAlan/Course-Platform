<x-app-layout :title="'Chat dengan '.$thread->student->name">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0" style="height: 70vh; display:flex; flex-direction:column;">

                        {{-- Header --}}
                        <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">
                                    {{ $thread->student->name }}
                                </div>
                                <div class="small text-muted">
                                    {{ $thread->course->title }}
                                </div>
                            </div>
                            <a href="{{ route('teacher.private-chats.index') }}"
                               class="small text-decoration-none">
                                &larr; Kembali
                            </a>
                        </div>

                        {{-- Pesan --}}
                        <div id="private-chat-box-teacher"
                             class="flex-grow-1 overflow-auto p-3"
                             style="background:#f9fafb;">

                            @forelse($messages as $msg)
                                @php $mine = $msg->sender_id === auth()->id(); @endphp

                                <div class="mb-2 d-flex {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="px-3 py-2 rounded-3"
                                         style="max-width:70%;
                                                background: {{ $mine ? '#4f46e5' : '#e5e7eb' }};
                                                color: {{ $mine ? 'white' : '#111827' }};">
                                        <small class="fw-semibold d-block" style="opacity:.9;">
                                            {{ $msg->sender->name }}
                                        </small>
                                        <div class="small">
                                            {{ $msg->message }}
                                        </div>
                                        <small class="d-block text-end mt-1" style="opacity:.6; font-size:10px;">
                                            {{ $msg->created_at->format('d M H:i') }}
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small text-center mt-4">
                                    Belum ada percakapan.
                                </p>
                            @endforelse
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('teacher.private-chats.store', $thread) }}"
                              method="POST"
                              class="d-flex gap-2 p-3 border-top">
                            @csrf
                            <input type="text"
                                   name="message"
                                   class="form-control rounded-pill"
                                   placeholder="Tulis balasan ke siswa..."
                                   required>
                            <button class="btn btn-primary rounded-pill px-4">
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const box = document.getElementById('private-chat-box-teacher');
            if (box) box.scrollTop = box.scrollHeight;
        }, 300);
    </script>
</x-app-layout>
