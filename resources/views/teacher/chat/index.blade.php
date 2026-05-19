<x-app-layout title="Chat Privat Siswa">
    <div class="container py-4">
        <h1 class="h5 mb-3">Chat Privat Siswa</h1>
        <p class="small text-muted mb-3">
            Daftar percakapan privat antara Anda dan siswa di berbagai course.
        </p>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Siswa</th>
                            <th>Course</th>
                            <th>Terakhir Update</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($threads as $thread)
                            <tr>
                                <td>{{ $thread->student->name }}</td>
                                <td>{{ $thread->course->title }}</td>
                                <td class="small text-muted">
                                    {{ $thread->updated_at->format('d M Y H:i') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('teacher.private-chats.show', $thread) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Buka Chat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted small py-3">
                                    Belum ada chat privat dari siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
