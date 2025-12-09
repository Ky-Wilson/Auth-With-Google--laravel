<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
 public function index()
{
    $brands = Brand::where('user_id', auth()->id())
                   ->latest()
                   ->paginate(15); // ou 10, 20, 25… comme tu veux

    return view('brands.index', compact('brands'));
}

    public function create()
    {
        return view('brands.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:brands,name,NULL,id,user_id,'.auth()->id(),
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $data = $request->only('name');

    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Déplace directement dans public/assets/brands
        $file->move(public_path('assets/brands'), $filename);
        
        $data['logo'] = 'assets/brands/' . $filename;
    }

    auth()->user()->brands()->create($data);

    return redirect()->route('user.brands.index')->with('success', 'Marque ajoutée');
}



    public function edit(Brand $brand)
    {
        $this->authorizeBrand($brand);
        return view('brands.edit', compact('brand'));
    }
public function update(Request $request, Brand $brand)
{
    $this->authorizeBrand($brand);

    $request->validate([
        'name' => 'required|string|max:255|unique:brands,name,'.$brand->id.',id,user_id,'.auth()->id(),
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $data = $request->only('name');

    if ($request->hasFile('logo')) {
        // Supprime l'ancien logo s'il existe
        if ($brand->logo && file_exists(public_path($brand->logo))) {
            unlink(public_path($brand->logo));
        }

        $file = $request->file('logo');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/brands'), $filename);

        $data['logo'] = 'assets/brands/' . $filename;
    }

    $brand->update($data);

    return redirect()->route('user.brands.index')->with('success', 'Marque modifiée');
}
    public function destroy(Brand $brand)
    {
        $this->authorizeBrand($brand);
        $brand->delete();
        return back()->with('success', 'Marque supprimée');
    }

    private function authorizeBrand(Brand $brand)
    {
        if ($brand->user_id !== auth()->id()) abort(403);
    }
}