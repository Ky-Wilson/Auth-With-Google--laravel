@extends('layouts.master')

@section('title', 'Ajouter une catégorie')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-900">Ajouter une catégorie</h1>

    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-6 py-6">
            <form action="{{ route('user.categories.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                        Nom de la catégorie <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Homme, Femme, Enfant, Solaire..." required autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('user.categories.index') }}"
                       class="px-5 py-2 text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection