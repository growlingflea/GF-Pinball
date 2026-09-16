<x-layouts.app>
    <div class="welcome-hero" style="background-image: linear-gradient(rgba(255,255,255,0.75), rgba(255,255,255,0.75)), url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center;">
        <h1>GF Pinball (thats sum good fuckin pinball!)</h1>
        <p>Search for the bar you're at, or pick a location below.</p>

        <div class="location-search">
            <input
                type="text"
                id="location-search-input"
                class="location-search__input"
                placeholder="Search for a bar or venue..."
                autocomplete="off"
            >
            <div id="location-search-results" class="location-search__results"></div>
        </div>
    </div>

    <div class="location-links" id="location-links" hidden>
        @foreach ($locations as $location)
            <a href="{{ route('locations.show', $location->slug) }}"
               class="location-card"
               data-name="{{ Str::lower($location->name) }}">
                {{ $location->name }}
            </a>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('location-search-input');
            const resultsBox = document.getElementById('location-search-results');
            const cards = Array.from(document.querySelectorAll('#location-links .location-card'));

            input.addEventListener('input', function () {
                const q = input.value.trim().toLowerCase();
                resultsBox.innerHTML = '';

                if (!q) {
                    resultsBox.classList.remove('is-open');
                    return;
                }

                const matches = cards.filter(card => card.dataset.name.includes(q));

                if (matches.length === 0) {
                    resultsBox.innerHTML = '<p class="location-search__empty">We don\'t have that bar in our system yet — check back once Pinball Map is connected!</p>';
                } else {
                    matches.forEach(function (card) {
                        const link = document.createElement('a');
                        link.href = card.getAttribute('href');
                        link.className = 'location-search__result';
                        link.textContent = card.textContent.trim();
                        resultsBox.appendChild(link);
                    });
                }

                resultsBox.classList.add('is-open');
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('.location-search')) {
                    resultsBox.classList.remove('is-open');
                }
            });
        });
    </script>
</x-layouts.app>
