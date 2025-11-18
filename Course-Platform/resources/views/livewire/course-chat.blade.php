<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3">
        <h6 class="fw-semibold mb-2">
            <i class="bi bi-chat-dots me-1"></i> Live Chat (Dummy)
        </h6>
        <p class="small text-muted">
            Versi demo: pesan hanya tersimpan selama halaman ini terbuka.
        </p>

        <div class="border rounded-3 p-2 mb-2" style="max-height:220px; overflow-y:auto;">
            @forelse($messages as $msg)
                <div class="mb-1">
                    <strong class="small">{{ $msg['user'] }}</strong>
                    <span class="text-muted small"> · {{ $msg['time'] }}</span>
                    <div class="small">{{ $msg['text'] }}</div>
                </div>
            @empty
                <div class="small text-muted">Belum ada pesan.</div>
            @endforelse
        </div>

        <form wire:submit.prevent="sendMessage" class="d-flex gap-2">
            <input type="text"
                   wire:model.defer="newMessage"
                   class="form-control form-control-sm"
                   placeholder="Ketik pesan...">
            <button class="btn btn-primary btn-sm">
                Kirim
            </button>
        </form>
    </div>
</div>
