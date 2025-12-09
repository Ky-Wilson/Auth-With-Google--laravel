@extends('layouts.master')

@section('title', 'Modifier la marque')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Modifier la marque</h1>
    </div>

    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-6 py-6">
            <form action="{{ route('user.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nom de la marque -->
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                        Nom de la marque <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           required autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo actuel + upload nouveau -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Logo actuel
                    </label>

                    <div class="mb-4">
                        @if ($brand->logo)
                            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}"
                                 class="object-contain w-auto h-24 border rounded-lg shadow-sm">
                        @else
                            <div class="flex items-center justify-center w-32 h-24 bg-gray-200 border-2 border-dashed rounded-lg">
                                <span class="text-gray-400">Aucun logo</span>
                            </div>
                        @endif
                    </div>

                    <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">
                        Changer le logo (optionnel)
                    </label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('user.brands.index') }}"
                       class="px-5 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection