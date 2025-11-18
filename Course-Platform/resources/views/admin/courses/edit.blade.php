<x-app-layout :title="'Edit Course – '.$course->title">
    <div class="container py-4">
        <div class="mb-3">
            <h1 class="h5 mb-1">Edit Course</h1>
            <p class="small text-muted mb-0">
                Perbarui informasi course dan penugasan teacher.
            </p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.courses.update',$course) }}"
                      method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-8">
                        <label class="form-label small">Judul Course</label>
                        <input type="text" name="title" value="{{ old('title',$course->title) }}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror">
                        @error('title') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Teacher</label>
                        <select name="teacher_id"
                                class="form-select form-select-sm @error('teacher_id') is-invalid @enderror">
                            <option value="">Pilih teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected(old('teacher_id',$course->teacher_id)==$teacher->id)>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Kategori</label>
                        <select name="category_id"
                                class="form-select form-select-sm @error('category_id') is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id',$course->category_id)==$cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date',$course->start_date?->format('Y-m-d')) }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date',$course->end_date?->format('Y-m-d')) }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-12">
                        <label class="form-label small">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="form-control form-control-sm @error('description') is-invalid @enderror">{{ old('description',$course->description) }}</textarea>
                        @error('description') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check small">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   id="is_active" value="1" {{ old('is_active',$course->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Course aktif
                            </label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-light btn-sm">
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
