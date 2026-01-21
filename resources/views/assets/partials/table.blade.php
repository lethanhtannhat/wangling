<div class="section">
    <div class="section-header">Asset List</div>
    <div class="section-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    @if(config('features.asset_sort'))
                        <th><x-sort-link col="asset_id" label="Asset ID" /></th>
                        <th><x-sort-link col="device_model" label="Device Model" /></th>
                        <th><x-sort-link col="os" label="OS" /></th>
                        <th><x-sort-link col="chip" label="Chip" /></th>
                        <th><x-sort-link col="memory" label="Memory" /></th>
                        <th><x-sort-link col="storage" label="Storage" /></th>
                        <th><x-sort-link col="serial_number" label="Serial Number" /></th>
                        <th><x-sort-link col="release_year" label="Release Year" /></th>
                        <th><x-sort-link col="purchase_date" label="Purchase Date" /></th>
                    @else
                        <th>Asset ID</th>
                        <th>Device Model</th>
                        <th>OS</th>
                        <th>Chip</th>
                        <th>Memory</th>
                        <th>Storage</th>
                        <th>Serial Number</th>
                        <th>Release Year</th>
                        <th>Purchase Date</th>
                    @endif

                    @if(config('features.asset_edit') || config('features.asset_delete'))
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody>
            @forelse ($assets as $asset)
                <tr>
                    <td>{{ $asset->asset_id }}</td>
                    <td>{{ $asset->device_model }}</td>
                    <td>
                        <span class="os-badge {{ strtolower($asset->os) }}">
                            {{ $asset->os }}
                        </span>
                    </td>
                    <td>{{ $asset->chip }}</td>
                    <td>{{ $asset->memory }} GB</td>
                    <td>{{ $asset->storage }} GB</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>{{ $asset->release_year }}</td>
                    <td>{{ \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') }}</td>
                    @if(config('features.asset_edit') || config('features.asset_delete'))
                    <td>
                        <div class="d-flex gap-1">
                            @if(config('features.asset_edit'))
                            <a
                                href="{{ route('assets.edit', $asset->id) }}"
                                class="btn btn-sm btn-primary"
                            >
                                Edit
                            </a>
                            @endif

                            @if(config('features.asset_delete'))
                            <button
                                class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $asset->id }}"
                                data-asset-id-str="{{ $asset->asset_id }}"
                            >
                                Delete
                            </button>
                            @endif
                        </div>
                    </td>
                    @endif

                </tr>

            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">
                        No assets found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
