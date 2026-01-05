<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editForm" action="">

            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Asset ID</label>
                        <input
                            type="text"
                            name="asset_id"
                            id="edit_asset_id"
                            class="form-control @error('asset_id') is-invalid @enderror"
                            value="{{ old('asset_id') }}"
                        >
                        @error('asset_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Device Model</label>
                        <input type="text" name="device_model" id="edit_device_model" class="form-control" value="{{ old('device_model') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">OS</label>
                        <select name="os" id="edit_os" class="form-select">
                            <option value="Win">Win</option>
                            <option value="Mac">Mac</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chip</label>
                        <input type="text" name="chip" id="edit_chip" class="form-control" value="{{ old('chip') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Memory (GB)</label>
                        <input type="number" name="memory" id="edit_memory" class="form-control" step="0.01" value="{{ old('memory') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Storage (GB)</label>
                        <input type="number" name="storage" id="edit_storage" class="form-control" step="0.01" value="{{ old('storage') }}" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Serial Number</label>
                        <input type="text" name="serial_number" id="edit_serial" class="form-control" value="{{ old('serial_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="text" name="purchase_date" id="edit_date" class="form-control" value="{{ old('purchase_date') }}">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>