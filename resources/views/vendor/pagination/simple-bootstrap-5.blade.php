@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
        <!-- Info Text -->
        <div style="text-align: center; color: #64748b; font-size: 0.95rem;">
            Showing <strong>{{ $paginator->firstItem() ?? 1 }}</strong> to <strong>{{ $paginator->lastItem() ?? $paginator->perPage() }}</strong> of <strong>{{ $paginator->total() }}</strong> results
        </div>

        <!-- Pagination Buttons -->
        <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #cbd5e1; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #ffffff; font-weight: 500; font-size: 0.95rem; cursor: not-allowed; opacity: 0.5;">
                    ← Previous
                </span>
            @else
                <a href="{{ $paginator->appends(request()->query())->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #0f172a; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #ffffff; font-weight: 500; font-size: 0.95rem; transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb'; this.style.color='#2563eb'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(37, 99, 235, 0.12)';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#0f172a'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    ← Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #64748b; text-decoration: none; border: none; background: transparent; font-weight: 500; font-size: 0.95rem; cursor: default;">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #ffffff; text-decoration: none; border: 1px solid #2563eb; border-radius: 0.75rem; background: #2563eb; font-weight: 700; font-size: 0.95rem; cursor: default; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.15);">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $paginator->appends(request()->query())->url($page) }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #0f172a; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #ffffff; font-weight: 500; font-size: 0.95rem; transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb'; this.style.color='#2563eb'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(37, 99, 235, 0.12)';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#0f172a'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends(request()->query())->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #0f172a; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #ffffff; font-weight: 500; font-size: 0.95rem; transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb'; this.style.color='#2563eb'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(37, 99, 235, 0.12)';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#cbd5e1'; this.style.color='#0f172a'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    Next →
                </a>
            @else
                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.85rem; height: 2.85rem; padding: 0 0.5rem; color: #cbd5e1; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 0.75rem; background: #ffffff; font-weight: 500; font-size: 0.95rem; cursor: not-allowed; opacity: 0.5;">
                    Next →
                </span>
            @endif
        </div>
    </nav>
@endif
