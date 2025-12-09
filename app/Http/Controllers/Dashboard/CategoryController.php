<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
                              ->latest()
                              ->paginate(15);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,NULL,id,user_id,'.auth()->id(),
        ]);

        auth()->user()->categories()->create($request->only('name'));

        return redirect()->route('user.categories.index')->with('success', 'Catégorie ajoutée');
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeCategory($category);

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id.',id,user_id,'.auth()->id(),
        ]);

        $category->update($request->only('name'));

        return redirect()->route('user.categories.index')->with('success', 'Catégorie modifiée');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);
        $category->delete();

        return back()->with('success', 'Catégorie supprimée');
    }

    private function authorizeCategory(Category $category)
    {
        if ($category->user_id !== auth()->id()) {
            abort(403);
        }
    }
}