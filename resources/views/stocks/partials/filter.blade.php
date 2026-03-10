<div class="section">
    <div class="section-header">Filter</div>
    <div class="section-body">
        <form action="{{ route('stocks.list') }}" method="GET" class="row row-cols-md-auto g-3 align-items-end">
            <div class="col">
                <label class="form-label">Department</label>
                <select name="department" class="form-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="form-label">OS (Mac/Win)</label>
                <select name="os" class="form-select" onchange="this.form.submit()">
                    <option value="">All OS</option>
                    <option value="Mac" {{ request('os') == 'Mac' ? 'selected' : '' }}>Mac</option>
                    <option value="Win" {{ request('os') == 'Win' ? 'selected' : '' }}>Win</option>
                </select>
            </div>
            <div class="col">
                <a href="{{ route('stocks.list') }}" class="btn-submit text-decoration-none" style="margin: 0; width: 100px;">
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>
