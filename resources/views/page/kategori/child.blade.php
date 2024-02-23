<ul style="padding-top: 10px">
    @foreach ($childs as $child)
        <li>
            <div class="container m-0 p-0" style="display: flex; align-items: center;">
                <img src="{{ url('img/media/originals/' . $child->icon) }}" alt="icon {{ $child->kategori }}"
                    width="50px"> {{ $child->kategori }}
                <a href="{{ route('kategori.edit', $child->id) }}" class="btn btn-primary btn-sm mr-2">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-sm btn-danger fa fa-trash" onclick="hapus({{ $child->id }})"></button>
            </div>
            {{-- @if (count($child->childs))
                @include('category.manageChild', ['childs' => $child->childs])
            @endif --}}
        </li>
    @endforeach
</ul>
