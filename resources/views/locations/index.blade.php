<x-layouts.app>
    <x-slot name="title">Locations</x-slot>

    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Locations</h1>

        <div class="mb-6">
            <input
                type="text"
                disabled
                placeholder="Connecting to pinball maps soon!"
                class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2 text-gray-400 cursor-not-allowed"
            >
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($locations as $location)
                <a href="{{ route('locations.show', $location->slug) }}"
                   class="block rounded-lg border border-gray-200 hover:shadow-md transition p-4">
                    <h2 class="font-semibold text-lg">{{ $location->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">View machines on the floor &rarr;</p>
                </a>
            @endforeach
        </div>

        @if ($locations->isEmpty())
            <p class="text-center text-gray-400 mt-8">No locations yet.</p>
        @endif
    </div>
</x-layouts.app>
