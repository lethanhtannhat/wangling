<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\Employee;
use App\Models\Stock;

class AssetObserver
{
    /**
     * Khi asset được update, nếu asset_id thay đổi thì
     * cập nhật asset_id tương ứng ở employees và stocks.
     */
    public function updated(Asset $asset): void
    {
        // Chỉ xử lý khi asset_id thực sự thay đổi
        if (!$asset->wasChanged('asset_id')) {
            return;
        }

        $oldAssetId = $asset->getOriginal('asset_id');
        $newAssetId = $asset->asset_id;

        // Cập nhật employee đang dùng asset_id cũ
        Employee::where('asset_id', $oldAssetId)
            ->update(['asset_id' => $newAssetId]);

        // Cập nhật stock đang dùng asset_id cũ
        Stock::where('asset_id', $oldAssetId)
            ->update(['asset_id' => $newAssetId]);
    }
}
