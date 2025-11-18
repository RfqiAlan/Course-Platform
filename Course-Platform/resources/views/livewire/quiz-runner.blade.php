<div>
    @if(session('quiz_message'))
        <div class="alert alert-info small mb-2">
            {{ session('quiz_message') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <h3 class="h6 mb-3">
                Quiz: {{ $quiz->title }} <span class="text-muted small">(Lulus: {{ $quiz->pass_score }}%)</span>
            </h3>

            <form wire:submit.prevent="submit">
                @foreach($quiz->questions as $q)
                    <div class="mb-3">
                        <p class="small fw-semibold mb-1">
                            {{ $loop->iteration }}. {{ $q->question }}
                        </p>
                        @foreach($q->options as $opt)
                            <div class="form-check small">
                                <input class="form-check-input"
                                       type="radio"
                                       wire:model="answers.{{ $q->id }}"
                                       value="{{ $opt->id }}"
                                       id="q{{ $q->id }}_{{ $opt->id }}">
                                <label class="form-check-label" for="q{{ $q->id }}_{{ $opt->id }}">
                                    {{ $opt->text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <button class="btn btn-primary btn-sm">
                    Submit Quiz
                </button>
            </form>

            @if($score !== null)
                <hr>
                <p class="small mb-0">
                    Skor kamu: <strong>{{ $score }}%</strong> –
                    @if($isPassed)
                        <span class="text-success">LULUS</span>
                    @else
                        <span class="text-danger">BELUM LULUS</span>
                    @endif
                </p>
            @endif
        </div>
    </div>
</div>
