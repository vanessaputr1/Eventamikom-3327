<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $categories = Category::when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', '%'.$search.'%');
            })
            ->latest()
            ->get();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name']),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori harus diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name'], $category->id),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
