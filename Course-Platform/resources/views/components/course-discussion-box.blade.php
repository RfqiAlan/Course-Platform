@php
    use App\Models\DiscussionMessage;

    $messages = DiscussionMessage::where('course_id', $course->id)
        ->with('user')
        ->orderBy('created_at')
        ->get();
@endphp

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3" style="height: 340px; display:flex; flex-direction:column;">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-semibold mb-0">Diskusi Kelas</h6>
            <small class="text-muted">Course: {{ $course->title }}</small>
        </div>

        {{-- AREA PESAN --}}
        <div id="discussion-box"
             class="flex-grow-1 overflow-auto mb-2 p-2 rounded-3"
             style="background:#f9fafb; border:1px solid #eee;">

            @forelse($messages as $msg)
                @php
                    $isMine = $msg->user_id === auth()->id();
                @endphp

                <div class="mb-2 d-flex {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="px-3 py-2 rounded-3"
                         style="max-width:70%;
                                background: {{ $isMine ? '#4f46e5' : '#e5e7eb' }};
                                color: {{ $isMine ? 'white' : '#111827' }};">

                        <small class="fw-semibold d-block" style="opacity:.9;">
                            {{ $msg->user->name }}
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
                <p class="text-muted small text-center my-3">
                    Belum ada diskusi di kelas ini.
                </p>
            @endforelse
        </div>

        {{-- FORM KIRIM DISKUSI --}}
        <form action="{{ route(auth()->user()->role.'.courses.discussion.store', $course) }}"
              method="POST"
              class="d-flex gap-2">
            @csrf
            <input type="text"
                   name="message"
                   class="form-control rounded-pill"
                   placeholder="Tulis diskusi..."
                   required>
            <button class="btn btn-primary rounded-pill px-4">
                Kirim
            </button>
        </form>
    </div>
</div>

{{-- Auto scroll ke paling bawah --}}
<script>
    setTimeout(() => {
        const box = document.getElementById('discussion-box');
        if (box) box.scrollTop = box.scrollHeight;
    }, 200);
</script>
