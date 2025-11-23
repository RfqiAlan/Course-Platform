<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CourseCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryId = '';
    public $myOnly = false;
    public $categories;

    protected $updatesQueryString = ['search', 'categoryId', 'myOnly', 'page'];

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingMyOnly()
    {
        $this->resetPage();
    }

    public function render()
{
    $query = Course::with(['teacher', 'category'])
        ->withCount('students');

    if ($this->search) {
        $q = '%' . $this->search . '%';
        $query->where(function ($sub) use ($q) {
            $sub->where('title', 'like', $q)
                ->orWhereHas('teacher', function ($teacherQuery) use ($q) {
                    $teacherQuery->where('name', 'like', $q);
                });
        });
    }

    if ($this->categoryId) {
        $query->where('category_id', $this->categoryId);
    }

    if ($this->myOnly && auth()->check() && method_exists(auth()->user(), 'isStudent') && auth()->user()->isStudent()) {
        $userId = auth()->id();
        $query->whereHas('students', function ($q) use ($userId) {
        $q->where('users.id', $userId); // ✅ ganti dari 'user_id'
    });
    }

    $courses = $query->paginate(9);

    return view('livewire.course-catalog', [
            'courses' => $courses,
        ])
        ->layout('components.layouts.app', [
            'title' => 'Katalog Kursus – EDVO',
        ]);
}

}
