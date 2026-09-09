<x-layouts.app>
    <x-slot name="title">{{ $rulesheet->title }}</x-slot>

    <div class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ route('rulesheets.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Rulesheets</a>

        <h1 class="text-2xl font-bold mt-4">{{ $rulesheet->title }}</h1>
        <p class="text-gray-500 mb-6">{{ $rulesheet->manufacturer }}</p>

        {{-- `prose` needs @tailwindcss/typography; drop the class if you don't have that plugin installed --}}
        <article class="prose max-w-none">
            {!! $html !!}
        </article>
    </div>
</x-layouts.app>
