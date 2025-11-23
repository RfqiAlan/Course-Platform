@php
    use App\Models\PrivateThread;
    use App\Models\PrivateMessage;

    $user = auth()->user();
    $teacher = $course->teacher ?? null;

    $thread = null;
    $messages = collect();

    if ($user && $teacher) {
        $thread = PrivateThread::where('course_id', $course->id)
            ->where('teacher_id', $teacher->id)
            ->where('student_id', $user->id)
            ->first();

        if ($thread) {
            $messages = $thread->messages()
                ->with('sender')
                ->orderBy('created_at')
                ->get();
        }
    }
@endphp

@if($teacher)
    <div class="card border-0 shadow-sm rounded-4 h-100">
        <div class="card-body p-3 d-flex flex-column" style="max-height: 380px;">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h6 class="fw-semibold mb-0">Chat Privat</h6>
                    <p class="small text-muted mb-0">
                        dengan {{ $teacher->name }}<br>
                        <span class="text-muted">{{ $course->title }}</span>
                    </p>
                </div>
            </div>

            {{-- Messages --}}
            <div id="private-chat-box-student"
                 class="flex-grow-1 mb-2 p-2 rounded-3"
                 style="background:#f9fafb; overflow-y:auto; border:1px solid #eee;">

                @forelse ($messages as $msg)
                    @php $mine = $msg->sender_id === auth()->id(); @endphp

                    <div class="mb-2 d-flex {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="px-3 py-2 rounded-3"
                             style="max-width: 80%;
                                    background: {{ $mine ? '#4f46e5' : '#e5e7eb' }};
                                    color: {{ $mine ? 'white' : '#111827' }};">
                            <small class="fw-semibold d-block" style="opacity:.9; font-size:11px;">
                                {{ $msg->sender->name }}
                            </small>
                            <div class="small" style="font-size:12px;">
                                {{ $msg->message }}
                            </div>
                            <small class="d-block text-end mt-1" style="opacity:.6; font-size:10px;">
                                {{ $msg->created_at->format('d M H:i') }}
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small text-center my-3">
                        Belum ada chat. Kirim pesan pertama ke guru.
                    </p>
                @endforelse
            </div>

            {{-- Form --}}
            <form action="{{ route('student.courses.chat.store', $course) }}"
                  method="POST"
                  class="d-flex gap-2">
                @csrf
                <input type="text"
                       name="message"
                       class="form-control form-control-sm rounded-pill"
                       placeholder="Tulis pesan..."
                       required>
                <button class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-send"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const box = document.getElementById('private-chat-box-student');
            if (box) box.scrollTop = box.scrollHeight;
        }, 300);
    </script>
@endif
