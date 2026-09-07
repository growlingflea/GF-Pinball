<x-layouts.app>
    <div class="welcome-hero">
        <h1>GF Pinball</h1>
        <p>Pick a location to see what's on the floor.</p>
    </div>

    <div class="location-links">
        <a href="{{ route('locations.show', 'moonshot') }}" class="location-card">Moonshot</a>
        <a href="{{ route('locations.show', 'gift') }}" class="location-card">Gift</a>
    </div>
</x-layouts.app>
