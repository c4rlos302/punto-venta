<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $category)
    {
        return view('categories.create', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'No puedes eliminar esta categoría porque tiene productos asociados.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
