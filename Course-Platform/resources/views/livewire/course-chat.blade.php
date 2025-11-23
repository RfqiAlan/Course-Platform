{{-- resources/views/livewire/course-chat.blade.php --}}

@php
    // pastikan selalu ada collection, walaupun property belum ke-set
    $msgs = $chatMessages ?? collect();
@endphp

<div class="d-flex flex-column" style="height: 320px;">
    {{-- Area pesan --}}
    <div class="flex-grow-1 border rounded-3 p-2 mb-2 bg-light"
         style="overflow-y:auto; max-height:260px;">
        @forelse($msgs as $msg)
            @php
                $isMe = auth()->check() && ($msg->user->id ?? null) === auth()->id();
            @endphp

            <div class="d-flex mb-2 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="px-3 py-2 rounded-3 small"
                     style="
                        max-width: 80%;
                        background-color: {{ $isMe ? '#0d6efd' : '#ffffff' }};
                        color: {{ $isMe ? '#ffffff' : '#111827' }};
                        box-shadow: 0 1px 2px rgba(15,23,42,.08);
                     ">
                    <div class="fw-semibold mb-1" style="font-size: .75rem;">
                        {{ $msg->user->name ?? 'User' }}
                    </div>
                    <div class="mb-1" style="font-size: .8rem; white-space: pre-line;">
                        {{ $msg->message }}
                    </div>
                    <div class="text-muted" style="font-size: .7rem;">
                        {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted small mt-3">
                Belum ada pesan. Mulai percakapan pertama di kelas ini.
            </div>
        @endforelse
    </div>

    {{-- Form input --}}
    <form wire:submit.prevent="send" class="d-flex gap-2">
        <input type="text"
               wire:model.defer="newMessage"
               class="form-control form-control-sm"
               placeholder="Tulis pesan..."
        >
        <button class="btn btn-primary btn-sm">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>

    @error('newMessage')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
