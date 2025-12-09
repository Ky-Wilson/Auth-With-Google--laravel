<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Glasses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlassesController extends Controller
{
    public function index()
    {
        $glasses = Glasses::where('user_id', auth()->id())
                          ->with(['brand', 'category'])
                          ->latest()
                          ->paginate(12);

        return view('glasses.index', compact('glasses'));
    }

    public function create()
    {
        $brands     = Brand::where('user_id', auth()->id())->orderBy('name')->get();
        $categories = Category::where('user_id', auth()->id())->orderBy('name')->get();

        return view('glasses.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id'       => 'required|exists:brands,id',
            'category_id'    => 'required|exists:categories,id',
            'reference'      => 'required|string|max:100',
            'color'          => 'required|string|max:50',
            'price'          => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'total_width'    => 'required|integer|min:100|max:200',
            'lens_width'     => 'required|integer|min:30|max:70',
            'bridge_width'   => 'required|integer|min:10|max:30',
            'temple_length'  => 'required|integer|min:120|max:160',
            'stock'          => 'required|integer|min:0',
            'image_front'    => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_side'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_worn'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'description'    => 'nullable|string',
        ]);

        $data = $request->only([
            'brand_id', 'category_id', 'reference', 'color', 'price',
            'purchase_price', 'total_width', 'lens_width', 'bridge_width',
            'temple_length', 'stock', 'description'
        ]);

        // Gestion des images → public/assets/glasses
        $data['image_front'] = $this->uploadImage($request->file('image_front'), 'front');
        if ($request->hasFile('image_side')) {
            $data['image_side'] = $this->uploadImage($request->file('image_side'), 'side');
        }
        if ($request->hasFile('image_worn')) {
            $data['image_worn'] = $this->uploadImage($request->file('image_worn'), 'worn');
        }

        $data['user_id'] = auth()->id();

        // Génération du slug
        $baseSlug = Str::slug("{$request->brand_id}-{$request->reference}-{$request->color}");
        $slug = $baseSlug;
        $i = 1;
        while (Glasses::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $data['slug'] = $slug;

        Glasses::create($data);

        return redirect()->route('user.glasses.index')->with('success', 'Lunettes ajoutées avec succès');
    }

    public function edit(Glasses $glass)
    {
        $this->authorizeGlass($glass);

        $brands     = Brand::where('user_id', auth()->id())->orderBy('name')->get();
        $categories = Category::where('user_id', auth()->id())->orderBy('name')->get();

        return view('glasses.edit', compact('glass', 'brands', 'categories'));
    }

    public function update(Request $request, Glasses $glass)
    {
        $this->authorizeGlass($glass);

        $request->validate([
            'brand_id'       => 'required|exists:brands,id',
            'category_id'    => 'required|exists:categories,id',
            'reference'      => 'required|string|max:100',
            'color'          => 'required|string|max:50',
            'price'          => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'total_width'    => 'required|integer|min:100|max:200',
            'lens_width'     => 'required|integer|min:30|max:70',
            'bridge_width'   => 'required|integer|min:10|max:30',
            'temple_length'  => 'required|integer|min:120|max:160',
            'stock'          => 'required|integer|min:0',
            'image_front'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_side'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image_worn'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'description'    => 'nullable|string',
        ]);

        $data = $request->only([
            'brand_id', 'category_id', 'reference', 'color', 'price',
            'purchase_price', 'total_width', 'lens_width', 'bridge_width',
            'temple_length', 'stock', 'description'
        ]);

        if ($request->hasFile('image_front')) {
            $this->deleteImage($glass->image_front);
            $data['image_front'] = $this->uploadImage($request->file('image_front'), 'front');
        }
        if ($request->hasFile('image_side')) {
            $this->deleteImage($glass->image_side);
            $data['image_side'] = $this->uploadImage($request->file('image_side'), 'side');
        }
        if ($request->hasFile('image_worn')) {
            $this->deleteImage($glass->image_worn);
            $data['image_worn'] = $this->uploadImage($request->file('image_worn'), 'worn');
        }

        // Mise à jour du slug si nécessaire
        $baseSlug = Str::slug("{$request->brand_id}-{$request->reference}-{$request->color}");
        $slug = $baseSlug;
        $i = 1;
        while (Glasses::where('slug', $slug)->where('id', '!=', $glass->id)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $data['slug'] = $slug;

        $glass->update($data);

        return redirect()->route('user.glasses.index')->with('success', 'Lunettes modifiées');
    }

    public function destroy(Glasses $glass)
    {
        $this->authorizeGlass($glass);

        $this->deleteImage($glass->image_front);
        $this->deleteImage($glass->image_side);
        $this->deleteImage($glass->image_worn);

        $glass->delete();

        return back()->with('success', 'Lunettes supprimées');
    }

    private function uploadImage($file, $prefix = '')
    {
        $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/glasses'), $filename);
        return 'assets/glasses/' . $filename;
    }

    private function deleteImage($path)
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    private function authorizeGlass(Glasses $glass)
    {
        if ($glass->user_id !== auth()->id()) {
            abort(403);
        }
    }
}