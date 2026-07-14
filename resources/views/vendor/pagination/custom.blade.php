@if ($paginator->hasPages())
    <div class="pagination-wrapper">

        {{-- Per Page Selector --}}
        <div class="pagination-info">
            <span>Menampilkan</span>
            <select onchange="changePerPage(this.value)" class="per-page-select">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
            <span>dari <strong>{{ $paginator->total() }}</strong> data</span>
        </div>

        {{-- Page Buttons --}}
        <div class="pagination-nav">

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <span class="page-btn disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="page-btn dots">…</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-btn disabled"><i class="fas fa-chevron-right"></i></span>
            @endif

        </div>
    </div>

    <style>
        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
        }

        .pagination-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .per-page-select {
            padding: 4px 8px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            background: var(--bg-card);
            color: var(--text-primary);
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .per-page-select:focus {
            border-color: var(--primary);
        }

        .pagination-nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-primary);
            transition: all .15s;
            cursor: pointer;
            user-select: none;
        }

        .page-btn:hover:not(.disabled):not(.active):not(.dots) {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .page-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            font-weight: 700;
            cursor: default;
        }

        .page-btn.disabled {
            opacity: .4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .page-btn.dots {
            border: none;
            background: transparent;
            cursor: default;
            color: var(--text-secondary);
        }
    </style>

    <script>
        function changePerPage(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.set('page', 1); // reset ke halaman 1
            window.location.href = url.toString();
        }
    </script>
@endif
