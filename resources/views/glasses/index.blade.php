@extends('layouts.master')

@section('title', 'Mes lunettes')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8" x-data="{ modalOpen: false, currentImage: '' }">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mes lunettes</h1>
        <a href="{{ route('user.glasses.create') }}"
           class="px-5 py-3 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
            + Ajouter des lunettes
        </a>
    </div>

    <!-- Version Desktop : Tableau classique -->
    <div class="hidden lg:block">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-xs font-medium text-left text-gray-500 uppercase">Photos</th>
                            <th class="px-4 py-3 text-xs font-medium text-left text-gray-500 uppercase">Marque / Réf.</th>
                            <th class="px-4 py-3 text-xs font-medium text-left text-gray-500 uppercase">Catégorie</th>
                            <th class="px-4 py-3 text-xs font-medium text-left text-gray-500 uppercase">Couleur</th>
                            <th class="px-4 py-3 text-xs font-medium text-center text-gray-500 uppercase">Dimensions (mm)</th>
                            <th class="px-4 py-3 text-xs font-medium text-center text-gray-500 uppercase">Prix vente</th>
                            <th class="px-4 py-3 text-xs font-medium text-center text-gray-500 uppercase">Prix achat</th>
                            <th class="px-4 py-3 text-xs font-medium text-center text-gray-500 uppercase">Stock</th>
                            <th class="px-4 py-3 text-xs font-medium text-center text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-3 text-xs font-medium text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($glasses as $glass)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div class="flex -space-x-3">
                                        @if($glass->image_front)
                                            <img src="{{ asset($glass->image_front) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_front) }}'"
                                                 class="object-cover transition border-4 border-white rounded w-14 h-14 cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Face">
                                        @endif
                                        @if($glass->image_side)
                                            <img src="{{ asset($glass->image_side) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_side) }}'"
                                                 class="object-cover transition border-4 border-white rounded w-14 h-14 cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Côté">
                                        @endif
                                        @if($glass->image_worn)
                                            <img src="{{ asset($glass->image_worn) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_worn) }}'"
                                                 class="object-cover transition border-4 border-white rounded w-14 h-14 cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Portée">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $glass->brand->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $glass->reference }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $glass->category->name }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $glass->color }}</td>
                                <td class="px-4 py-4 text-xs text-center">
                                    <div class="space-y-1">
                                        <div>↔ {{ $glass->total_width }}</div>
                                        <div>{{ $glass->lens_width }} □ {{ $glass->bridge_width }} □ {{ $glass->temple_length }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 font-semibold text-center">{{ number_format($glass->price, 2) }} €</td>
                                <td class="px-4 py-4 text-sm text-center text-gray-600">
                                    {{ $glass->purchase_price ? number_format($glass->purchase_price, 2).' €' : '—' }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $glass->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $glass->stock }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $glass->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $glass->is_active ? 'Active' : 'Désactivée' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-right">
                                    <a href="{{ route('user.glasses.edit', $glass) }}" class="mr-4 text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <form action="{{ route('user.glasses.destroy', $glass) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer ?')" class="text-red-600 hover:text-red-900">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="px-6 py-12 text-center text-gray-500">Aucune lunette</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $glasses->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Version Mobile : Cartes -->
    <div class="space-y-4 lg:hidden">
        @forelse($glasses as $glass)
            <div class="p-5 bg-white rounded-lg shadow">
                <!-- Photos -->
                <div class="flex justify-center gap-2 mb-4">
                    @if($glass->image_front)
                        <img src="{{ asset($glass->image_front) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_front) }}'"
                             class="object-cover w-20 h-20 transition rounded cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Face">
                    @endif
                    @if($glass->image_side)
                        <img src="{{ asset($glass->image_side) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_side) }}'"
                             class="object-cover w-20 h-20 transition rounded cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Côté">
                    @endif
                    @if($glass->image_worn)
                        <img src="{{ asset($glass->image_worn) }}" @click="modalOpen = true; currentImage = '{{ asset($glass->image_worn) }}'"
                             class="object-cover w-20 h-20 transition rounded cursor-zoom-in hover:ring-4 hover:ring-indigo-300" alt="Portée">
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Marque</span><br>
                        <strong>{{ $glass->brand->name }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500">Référence</span><br>
                        <strong>{{ $glass->reference }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500">Catégorie</span><br>
                        <span class="text-indigo-600">{{ $glass->category->name }}</span>
                    </div>
                    >
                    <div>
                        <span class="text-gray-500">Couleur</span><br>
                        {{ $glass->color }}
                    </div>
                    <div>
                        <span class="text-gray-500">Dimensions</span><br>
                        <span class="text-xs">
                            ↔ {{ $glass->total_width }} | {{ $glass->lens_width }} □ {{ $glass->bridge_width }} □ {{ $glass->temple_length }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Prix vente</span><br>
                        <strong class="text-lg">{{ number_format($glass->price, 2) }} €</strong>
                    </div>
                    <div>
                        <span class="text-gray-500">Prix achat</span><br>
                        {{ $glass->purchase_price ? number_format($glass->purchase_price, 2).' €' : '—' }}
                    </div>
                    <div>
                        <span class="text-gray-500">Stock</span><br>
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $glass->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $glass->stock }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <span class="text-sm {{ $glass->is_active ? 'text-green-600' : 'text-gray-500' }}">
                        {{ $glass->is_active ? 'Active' : 'Désactivée' }}
                    </span>
                    <div class="flex gap-3">
                        <a href="{{ route('user.glasses.edit', $glass) }}" class="font-medium text-indigo-600">Modifier</a>
                        <form action="{{ route('user.glasses.destroy', $glass) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ?')" class="font-medium text-red-600">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-lg shadow">
                <p class="text-lg text-gray-500">Aucune lunette ajoutée pour le moment.</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $glasses->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Lightbox Zoom (identique) -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80"
         @click="modalOpen = false" @keydown.escape.window="modalOpen = false">
        <div class="relative w-full max-w-4xl p-4">
            <img :src="currentImage" class="max-w-full max-h-screen mx-auto rounded-lg shadow-2xl">
            <button @click="modalOpen = false" class="absolute text-4xl text-white top-4 right-4 hover:text-gray-300">×</button>
        </div>
    </div>
</div>
@endsection