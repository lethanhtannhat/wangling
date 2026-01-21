<div class="section">
    <div class="section-header">Filter</div>
    <div class="section-body">
        <form id="filterForm" class="row row-cols-md-5 g-3 align-items-end" action="{{ route('assets.list') }}" method="GET">

            <div class="col">
                <label class="form-label">Asset ID / Model</label>
                <input type="text" name="keyword" class="form-control" placeholder="Type ID or Model..." value="{{ request('keyword') }}">
            </div>

            <div class="col">
                <label class="form-label">Type of Laptop</label>
                <select name="os" class="form-select">
                    <option value="all" {{ request('os') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="Win" {{ request('os') == 'Win' ? 'selected' : '' }}>Windows</option>
                    <option value="Mac" {{ request('os') == 'Mac' ? 'selected' : '' }}>Mac</option>
                </select>
            </div>

            <div class="col">
                <label class="form-label">Chip</label>
                <input type="text" name="chip" class="form-control" placeholder="Ex: Intel, M1..." value="{{ request('chip') }}">
            </div>

            <div class="col">
                <label class="form-label">Memory (GB)</label>
                <input type="number" name="memory" class="form-control" placeholder="Ex: 8, 16" value="{{ request('memory') }}">
            </div>

            <div class="col">
                <label class="form-label">Storage</label>
                <input type="text" name="storage" class="form-control" placeholder="Ex: 512 GB SSD" value="{{ request('storage') }}">
            </div>

            <div class="col">
                <label class="form-label">From date</label>
                <input type="text" id="fromDate" name="from_date" class="form-control" placeholder="yyyy-mm-dd" value="{{ request('from_date') }}">
            </div>

            <div class="col">
                <label class="form-label">To date</label>
                <input type="text" id="toDate" name="to_date" class="form-control" placeholder="yyyy-mm-dd" value="{{ request('to_date') }}">
            </div>

            <div class="col">
                <label class="form-label">Release Year</label>
                <input type="number" name="release_year" class="form-control" placeholder="Ex: 2023" value="{{ request('release_year') }}">
            </div>

            <div class="col">
                <label class="form-label">Serial Number</label>
                <input type="text" name="serial_number" class="form-control" placeholder="Serial..." value="{{ request('serial_number') }}">
            </div>

            <div class="col d-flex align-items-end">
                <button type="submit" class="btn-submit w-100">
                    Search
                </button>
            </div>

        </form>
    </div>
</div>
