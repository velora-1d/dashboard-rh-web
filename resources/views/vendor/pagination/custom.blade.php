@if ($paginator->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: white; border-top: 1px solid #e2e8f0;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; color: #94a3b8; cursor: not-allowed; font-size: 14px; font-weight: 500;">
                <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                Previous
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #4f46e5; cursor: pointer; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
                Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div style="display: flex; gap: 6px; align-items: center;">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="padding: 8px 12px; color: #94a3b8; font-size: 14px;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 8px 14px; background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; border-radius: 8px; font-size: 14px; font-weight: 600; min-width: 40px; text-align: center; box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding: 8px 14px; background: white; border: 1px solid #e2e8f0; color: #64748b; border-radius: 8px; font-size: 14px; font-weight: 500; min-width: 40px; text-align: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0'">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #4f46e5; cursor: pointer; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                Next
                <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            </a>
        @else
            <button disabled style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; color: #94a3b8; cursor: not-allowed; font-size: 14px; font-weight: 500;">
                Next
                <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            </button>
        @endif
    </div>

    <script>
        // Re-initialize feather icons for pagination
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>
@endif
