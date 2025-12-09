@extends('layouts.master')

@section('title', 'Mes marques')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mes marques</h1>
        <a href="{{ route('user.brands.create') }}" class="px-4 py-2 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
            + Ajouter une marque
        </a>
    </div>

    <div class="mt-8 overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Logo</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nom</th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Ajoutée le</th>
                        <th scope="col" class="relative px-6 py-3 "><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($brands as $brand)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($brand->logo)
                                    <img src="{{ asset(  $brand->logo) }}" alt="{{ $brand->name }}" class="object-contain w-12 h-12 rounded">
                                @else
                                    <div class="flex items-center justify-center w-12 h-12 bg-gray-200 border-2 border-dashed rounded">
                                        <span class="text-xs text-gray-400">Sans logo</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $brand->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $brand->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('user.brands.edit', $brand) }}" class="mr-4 text-indigo-600 hover:text-indigo-900">Modifier</a>
                                <form action="{{ route('user.brands.destroy', $brand) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer cette marque ?')" class="text-red-600 hover:text-red-900">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                Aucune marque ajoutée pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Bootstrap 5 -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $brands->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection