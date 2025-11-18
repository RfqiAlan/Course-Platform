<x-app-layout :title="'Soal Quiz – '.$quiz->title">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Soal untuk Quiz</h1>
                <p class="small text-muted mb-0">
                    Quiz: <strong>{{ $quiz->title }}</strong> (Lulus: {{ $quiz->pass_score }}%)
                </p>
            </div>
            <a href="{{ route('teacher.quizzes.questions.create',$quiz) }}"
               class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Soal
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light small">
                        <tr>
                            <th>#</th>
                            <th>Pertanyaan</th>
                            <th>Opsi Jawaban</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="max-width:260px;">
                                    {{ \Illuminate\Support\Str::limit($question->question, 80) }}
                                </td>
                                <td>
                                    @foreach($question->options as $opt)
                                        <div>
                                            @if($opt->is_correct)
                                                <span class="badge bg-success-subtle text-success me-1">
                                                    Benar
                                                </span>
                                            @endif
                                            {{ $opt->text }}
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('teacher.quizzes.questions.edit',$question) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('teacher.quizzes.questions.destroy',$question) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Belum ada soal untuk quiz ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-light btn-sm">
                &laquo; Kembali ke daftar quiz
            </a>
        </div>
    </div>
</x-app-layout>
