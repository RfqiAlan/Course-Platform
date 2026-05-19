@props([
    'course',
    'discussions' => [],
])

@php
    $user = auth()->user();
    $role = $user?->role;
@endphp

{{-- Hanya teacher & student yang boleh melihat dan mengirim diskusi --}}
@if(in_array($role, ['teacher', 'student']))
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0">Diskusi Kelas</h6>
                <p class="text-muted small mb-0">
                    Ruang tanya jawab seputar materi course <strong>{{ $course->title }}</strong>.
                </p>
            </div>
        </div>

        <div class="card-body" style="max-height: 320px; overflow-y: auto;">
            @forelse($discussions as $discussion)
                <div class="mb-3 pb-3 border-bottom border-light-subtle">
                    <div class="d-flex align-items-center mb-1">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                             style="width: 28px; height: 28px; font-size: 0.75rem;">
                            {{ strtoupper(substr($discussion->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="small fw-semibold">
                                {{ $discussion->user->name ?? 'User' }}
                                @if($discussion->user->role === 'teacher')
                                    <span class="badge bg-indigo-100 text-indigo-700 border rounded-pill ms-1"
                                          style="font-size: 9px;">
                                        Teacher
                                    </span>
                                @elseif($discussion->user->role === 'student')
                                    <span class="badge bg-emerald-100 text-emerald-700 border rounded-pill ms-1"
                                          style="font-size: 9px;">
                                        Student
                                    </span>
                                @endif
                            </div>
                            <div class="text-muted xsmall">
                                {{ $discussion->created_at?->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 small">
                        {{ $discussion->message }}
                    </p>
                </div>
            @empty
                <div class="text-center text-muted small py-3">
                    Belum ada diskusi. Mulai pertanyaan pertama kamu terkait materi course ini.
                </div>
            @endforelse
        </div>

        {{-- FORM KIRIM DISKUSI --}}
        <div class="card-footer bg-light-subtle border-0">
            @php
                // Tentukan route form berdasarkan role
                $discussionRoute = null;

                if ($role === 'teacher') {
                    $discussionRoute = route('teacher.courses.discussion.store', $course);
                } elseif ($role === 'student') {
                    $discussionRoute = route('student.courses.discussion.store', $course);
                }
            @endphp

            @if($discussionRoute)
                <form action="{{ $discussionRoute }}" method="POST" class="d-flex align-items-start gap-2">
                    @csrf
                    <div class="flex-grow-1">
                        <textarea
                            name="message"
                            rows="2"
                            class="form-control form-control-sm @error('message') is-invalid @enderror"
                            placeholder="Tulis pertanyaan atau komentar kamu di sini...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback small">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-send-fill me-1"></i> Kirim
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endif
