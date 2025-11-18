<x-app-layout :title="'Edit Modul – '.$module->course->title">
    <div class="container py-4">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">Edit Modul</h1>
                <p class="small text-muted mb-0">
                    Course: <strong>{{ $module->course->title }}</strong>
                </p>
            </div>
            <a href="{{ route('teacher.courses.modules.index',$module->course) }}"
               class="btn btn-light btn-sm">
                Kembali ke daftar modul
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('teacher.modules.update',$module) }}" method="POST" class="row g-3">
                    @csrf @method('PUT')

                    <div class="col-md-8">
                        <label class="form-label small">Judul Modul</label>
                        <input type="text" name="title" value="{{ old('title',$module->title) }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Urutan</label>
                        <input type="number" name="order" value="{{ old('order',$module->order) }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('teacher.courses.modules.index',$module->course) }}"
                           class="btn btn-light btn-sm">
                            Kembali
                        </a>
                        <button class="btn btn-primary btn-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
