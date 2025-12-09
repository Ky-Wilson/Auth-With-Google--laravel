@extends('layouts.master')

@section('title', 'Ajouter des lunettes')

@section('content')
<div class="max-w-4xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
    <h1 class="mb-8 text-3xl font-bold text-gray-900">Ajouter des lunettes</h1>

    <div class="overflow-hidden bg-white shadow rounded-xl">
        <div class="px-8 py-8">
            <form action="{{ route('user.glasses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Marque & Catégorie -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Marque <span class="text-red-600">*</span></label>
                        <select name="brand_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Choisir une marque</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Catégorie <span class="text-red-600">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Choisir une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Référence & Couleur -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Référence <span class="text-red-600">*</span></label>
                        <input type="text" name="reference" value="{{ old('reference') }}" required
                               class="w-full px-4 py-2 border rounded-lg @error('reference') border-red-500 @enderror">
                        @error('reference') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Couleur <span class="text-red-600">*</span></label>
                        <input type="text" name="color" value="{{ old('color') }}" required placeholder="ex: Noir mat, Écaille"
                               class="w-full px-4 py-2 border rounded-lg @error('color') border-red-500 @enderror">
                        @error('color') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Prix de vente (€) <span class="text-red-600">*</span></label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required
                               class="w-full px-4 py-2 border rounded-lg @error('price') border-red-500 @enderror">
                        @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Prix d'achat (€)</label>
                        <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price') }}"
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <!-- Mesures en mm -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Largeur totale (mm) <span class="text-red-600">*</span></label>
                        <input type="number" name="total_width" value="{{ old('total_width') }}" required min="100" max="200"
                               class="w-full px-4 py-2 border rounded-lg @error('total_width') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Largeur verre (mm) <span class="text-red-600">*</span></label>
                        <input type="number" name="lens_width" value="{{ old('lens_width') }}" required min="30" max="70"
                               class="w-full px-4 py-2 border rounded-lg @error('lens_width') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Pont (mm) <span class="text-red-600">*</span></label>
                        <input type="number" name="bridge_width" value="{{ old('bridge_width') }}" required min="10" max="30"
                               class="w-full px-4 py-2 border rounded-lg @error('bridge_width') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Longueur branche (mm) <span class="text-red-600">*</span></label>
                        <input type="number" name="temple_length" value="{{ old('temple_length') }}" required min="120" max="160"
                               class="w-full px-4 py-2 border rounded-lg @error('temple_length') border-red-500 @enderror">
                    </div>

                    <!-- Stock -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Stock <span class="text-red-600">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                               class="w-full px-4 py-2 border rounded-lg @error('stock') border-red-500 @enderror">
                    </div>
                </div>

                <!-- Images -->
                <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-3">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Photo de face <span class="text-red-600">*</span></label>
                        <input type="file" name="image_front" accept="image/*" required
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-700">
                        @error('image_front') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Photo de côté</label>
                        <input type="file" name="image_side" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-100">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Photo portée</label>
                        <input type="file" name="image_worn" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-100">
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-8">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Description (facultatif)</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description') }}</textarea>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end gap-4 mt-10">
                    <a href="{{ route('user.glasses.index') }}"
                       class="px-6 py-3 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-8 py-3 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Enregistrer les lunettes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection