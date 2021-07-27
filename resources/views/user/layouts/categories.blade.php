<ul class="standard_dropdown top_bar_dropdown">
    @foreach ($categories as $category)
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{ route('user.category_documents', ['id' => $category->id]) }}"
                id="dropdown1">{{ $category->name }}</a>
            @include('user.layouts.categories', ['categories' => $category->categories])
        </li>
    @endforeach
</ul>
