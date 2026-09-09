<x-layouts.app>
    <x-slot name="title">{{ $feature }}</x-slot>

    <div class="max-w-2xl mx-auto px-4 py-24 text-center">
        <span class="text-5xl">🚧</span>
        <h1 class="text-2xl font-bold mt-4">{{ $feature }}</h1>
        <p class="text-gray-500 mt-2">This page is coming soon.</p>
        <a href="{{ route('games.index') }}" class="inline-block mt-6 text-blue-600 hover:underline">&larr; Back to Games</a>
    </div>
</x-layouts.app>
