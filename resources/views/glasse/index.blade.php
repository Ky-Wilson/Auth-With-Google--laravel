<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lunettes de vue & solaires - {{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen" x-data="{ modalOpen: false, currentImage: '' }">
    
    <!-- Header simple -->
    <!-- Header public – visible sur toute la vitrine -->
<header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A] py-6">
    <div class="flex items-center justify-between px-6 mx-auto max-w-7xl">
        <!-- Logo / Nom du site -->
        <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-tight">
            Lunetterie
        </a>

        <!-- Boutons selon l’état de connexion -->
        <div class="flex items-center gap-6 text-sm">
            @auth
                <a href="{{ route('user.dashboard') }}" class="font-medium underline hover:no-underline">
                    Mon espace
                </a>
            @else
                <a href="{{ route('login') }}" class="font-medium hover:underline">
                    Se connecter
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        S’inscrire
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>

    <div class="px-6 py-12 mx-auto max-w-7xl">
        <h2 class="mb-12 text-4xl font-medium text-center">Nos lunettes</h2>

        <div class="grid gap-8 lg:grid-cols-4">
            <!-- Filtres -->
            <aside class="space-y-8 lg:col-span-1">
                <form method="GET" class="space-y-6">
                    <!-- Marque -->
                    <div>
                        <h3 class="mb-3 font-medium">Marque</h3>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="brand" value="{{ $brand->id }}"
                                           {{ request('brand') == $brand->id ? 'checked' : '' }}
                                           class="w-4 h-4 text-indigo-600">
                                    <span>{{ $brand->name }}</span>
                                </label>
                            @endforeach
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="brand" value="" {{ !request('brand') ? 'checked' : '' }}>
                                <span>Toutes</span>
                            </label>
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <h3 class="mb-3 font-medium">Catégorie</h3>
                        <div class="space-y-2">
                            @foreach($categories as $cat)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="category" value="{{ $cat->id }}"
                                           {{ request('category') == $cat->id ? 'checked' : '' }}
                                           class="w-4 h-4 text-indigo-600">
                                    <span>{{ $cat->name }}</span>
                                </label>
                            @endforeach
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}>
                                <span>Toutes</span>
                            </label>
                        </div>
                    </div>

                    <!-- Taille -->
                    <div>
                        <h3 class="mb-3 font-medium">Taille (largeur totale)</h3>
                        <div class="space-y-2">
                            @foreach($sizes as $size)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="size" value="{{ $size }}"
                                           {{ request('size') == $size ? 'checked' : '' }}
                                           class="w-4 h-4 text-indigo-600">
                                    <span>{{ $size }} mm</span>
                                </label>
                            @endforeach
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="size" value="" {{ !request('size') ? 'checked' : '' }}>
                                <span>Toutes</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Appliquer
                    </button>
                    <a href="{{ route('home') }}" class="block text-sm text-center text-gray-600 hover:underline">
                        Réinitialiser
                    </a>
                </form>
            </aside>

            <!-- Grille lunettes -->
            <div class="lg:col-span-3">
                @if($glasses->count() === 0)
                    <p class="py-20 text-center text-gray-500">Aucune lunette ne correspond à vos critères.</p>
                @else
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($glasses as $glass)
                            <a href="{{ route('glasses.show', $glass) }}" class="block group">
                                <div class="bg-white dark:bg-[#161615] rounded-xl shadow hover:shadow-xl transition overflow-hidden">
                                    @if($glass->image_front)
                                        <img src="{{ asset($glass->image_front) }}"
                                             @click.prevent="modalOpen = true; currentImage = '{{ asset($glass->image_front) }}'"
                                             class="object-cover w-full transition h-80 cursor-zoom-in group-hover:scale-105"
                                             alt="{{ $glass->brand->name }} {{ $glass->reference }}">
                                    @endif

                                    <div class="p-6">
                                        <h3 class="text-lg font-medium">{{ $glass->brand->name }} {{ $glass->reference }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $glass->color }}</p>
                                        <p class="mt-3 text-2xl font-medium">{{ number_format($glass->price, 2) }} €</p>
                                        <span class="inline-block px-3 py-1 mt-3 text-xs text-indigo-700 bg-indigo-100 rounded-full">
                                            {{ $glass->category->name }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $glasses->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Zoom Lightbox -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-90"
         @click="modalOpen = false" @keydown.escape.window="modalOpen = false">
        <img :src="currentImage" class="object-contain max-w-full max-h-full">
        <button @click="modalOpen = false" class="absolute text-5xl text-white top-8 right-8">&times;</button>
    </div>
</body>
</html>