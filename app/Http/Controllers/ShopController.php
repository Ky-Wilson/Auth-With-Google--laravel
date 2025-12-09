<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Glasses;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer toutes les marques/catégories pour les filtres
        $brands     = Brand::whereHas('glasses', fn($q) => $q->where('is_active', true))->orderBy('name')->get();
        $categories = Category::whereHas('glasses', fn($q) => $q->where('is_active', true))->orderBy('name')->get();

        // Tailles totales disponibles (ex: 135, 140, 145...)
        $sizes = Glasses::where('is_active', true)
                        ->select('total_width')
                        ->distinct()
                        ->orderBy('total_width')
                        ->pluck('total_width');

        // Query de base : lunettes actives uniquement
        $query = Glasses::where('is_active', true)
                        ->with(['brand', 'category'])
                        ->latest();

        // Filtres
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('size')) {
            $query->where('total_width', $request->size);
        }

        $glasses = $query->paginate(12)->withQueryString();

        return view('glasse.index', compact('glasses', 'brands', 'categories', 'sizes'));
    }

    public function show(Glasses $glass)
    {
        if (!$glass->is_active) {
            abort(404);
        }

        $glass->load(['brand', 'category']);

        // Suggestions similaires
        $related = Glasses::where('is_active', true)
                          ->where('category_id', $glass->category_id)
                          ->where('id', '!=', $glass->id)
                          ->inRandomOrder()
                          ->take(6)
                          ->get();

        return view('glasse.show', compact('glass', 'related'));
    }
}