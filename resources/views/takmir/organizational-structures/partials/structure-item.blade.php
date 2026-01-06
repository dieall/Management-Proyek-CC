<div class="mb-3 p-3 border rounded" style="margin-left: {{ $level * 30 }}px;">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            @if($structure->is_division)
                <h5 class="mb-1"><i class="fas fa-sitemap"></i> {{ $structure->division_name }}</h5>
                @if($structure->division_description)
                    <p class="text-muted small mb-0">{{ $structure->division_description }}</p>
                @endif
            @elseif($structure->position)
                <h5 class="mb-1"><i class="fas fa-user-tie"></i> {{ $structure->position->name }}</h5>
                @if($structure->position->description)
                    <p class="text-muted small mb-0">{{ $structure->position->description }}</p>
                @endif
            @endif
        </div>
        <div>
            <a href="{{ route('organizational-structures.show', $structure->id) }}" class="btn btn-info btn-sm" title="Detail">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('organizational-structures.edit', $structure->id) }}" class="btn btn-warning btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('organizational-structures.destroy', $structure->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    
    @if($structure->children->count() > 0)
        @foreach($structure->children as $child)
            @include('takmir.organizational-structures.partials.structure-item', ['structure' => $child, 'level' => $level + 1])
        @endforeach
    @endif
</div>








