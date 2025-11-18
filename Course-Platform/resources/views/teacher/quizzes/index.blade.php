<x-app-layout title="Quiz – Teacher">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Bank Quiz</h1>
                <p class="small text-muted mb-0">
                    Buat quiz untuk digunakan pada konten lesson.
                </p>
            </div>
            <a href="{{ route('teacher.quizzes.create') }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Quiz Baru
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Judul Quiz</th>
                            <th>Lulus</th>
                            <th>Jumlah Soal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($quizzes as $quiz)
                            <tr>
                                <td>{{ $loop->iteration + ($quizzes->firstItem() - 1) }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->pass_score }}%</td>
                                <td>{{ $quiz->questions->count() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('teacher.quizzes.edit',$quiz) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('teacher.quizzes.destroy',$quiz) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus quiz ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada quiz.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $quizzes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
