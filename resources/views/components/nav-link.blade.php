@php
//    $basePath = '/ims-web/public';
    $basePath = 'https://ims-web.test';
    $navLinks = [
        ['label' => 'Home', 'href' => $basePath . '/'],
        ['label' => 'Books', 'href' => $basePath . '/books'],
        ['label' => 'Genres', 'href' => $basePath . '/genres'],
        ['label' => 'Authors', 'href' => $basePath . '/authors'],
        ['label' => 'Publishers', 'href' => $basePath . '/publishers'],
        ['label' => 'Blog', 'href' => $basePath . '/blog'],
        ['label' => 'About', 'href' => $basePath . '/about'],
        ['label' => 'Contact', 'href' => $basePath . '/contact'],
    ];
@endphp
<nav class="flex-1 flex justify-center space-x-2">
    @foreach($navLinks as $link)
        @php
            $active = request()->is(ltrim(str_replace($basePath, '', $link['href']), '/')) || ($link['href'] === $basePath . '/' && request()->path() === ltrim($basePath . '/', '/'));
        @endphp
        <a href="{{ $link['href'] }}"
           class="relative px-4 py-2 rounded-full font-medium transition
                  {{ $active ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
            {{ $link['label'] }}
            @if($active)
                <span class="absolute left-1/2 -bottom-1.5 -translate-x-1/2 w-2 h-2 bg-blue-400 rounded-full"></span>
            @endif
        </a>
    @endforeach
</nav>
