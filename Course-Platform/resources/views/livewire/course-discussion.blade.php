<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3">
        <h6 class="fw-semibold mb-2">
            <i class="bi bi-chat-right-text me-1"></i> Forum Diskusi (Dummy)
        </h6>
        <p class="small text-muted">
            Versi demo: thread hanya ada selama halaman aktif.
        </p>

        <div class="mb-3" style="max-height:260px; overflow-y:auto;">
            @forelse($threads as $thread)
                <div class="border rounded-3 p-2 mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <strong>{{ $thread['topic'] }}</strong>
                        <span class="text-muted">{{ $thread['user'] }} · {{ $thread['time'] }}</span>
                    </div>
                    <div class="small text-muted">{{ $thread['body'] }}</div>
                </div>
            @empty
                <div class="small text-muted">Belum ada thread diskusi.</div>
            @endforelse
        </div>

        <form wire:submit.prevent="createThread" class="small">
            <div class="mb-2">
                <input type="text"
                       wire:model.defer="topic"
                       class="form-control form-control-sm"
                       placeholder="Judul/topik diskusi">
                @error('topic') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-2">
                <textarea wire:model.defer="body"
                          rows="2"
                          class="form-control form-control-sm"
                          placeholder="Isi diskusi"></textarea>
                @error('body') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <button class="btn btn-primary btn-sm">
                Buat Thread
            </button>
        </form>
    </div>
</div>
