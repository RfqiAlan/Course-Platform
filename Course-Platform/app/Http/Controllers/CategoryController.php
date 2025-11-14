<?php



namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Tampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(15);

        return view('categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->route('categories.index')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    /**
     * (Opsional) detail kategori – kalau tidak dipakai bisa redirect.
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.edit', $category);
    }

    /**
     * Form edit kategori.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->route('categories.index')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $category)
    {
        // kalau tidak mau hapus kalau masih dipakai course,
        // di migration tadi sudah kita set nullOnDelete di course.category_id
        $category->delete();

        return redirect()->route('categories.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }
}
