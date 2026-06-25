@if ($paginator->hasPages())
    <div class="custom-pagination" style="display: flex; justify-content: center; align-items: center; margin-top: var(--space-2xl); gap: 8px;">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: #f8fafc; color: #cbd5e1; cursor: not-allowed;">
                <i class="fa-solid fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: white; border: 1px solid #e2e8f0; color: var(--text-color); text-decoration: none; transition: all 0.2s;">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: #64748b;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: var(--primary); color: white; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: white; border: 1px solid #e2e8f0; color: var(--text-color); text-decoration: none; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='var(--text-color)';">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: white; border: 1px solid #e2e8f0; color: var(--text-color); text-decoration: none; transition: all 0.2s;">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background: #f8fafc; color: #cbd5e1; cursor: not-allowed;">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>
@endif
