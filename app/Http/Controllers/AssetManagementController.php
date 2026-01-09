<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use Carbon\Carbon;

class AssetManagementController extends Controller
{


    private function checkFeature($feature)
    {
        if (!config("features.{$feature}")) {
            abort(404);
        }
    }

    public function create()
    {
        $this->checkFeature('asset_create');
        return view('assets.create');
    }

    public function store(StoreAssetRequest $request)
    {
        $this->checkFeature('asset_create');
        Asset::create($request->validated());

        $target = \Route::has('assets.list') ? route('assets.list') : route('dashboard');
        return redirect($target)->with('success', 'Asset created successfully!');
    }

    public function edit(Asset $asset)
    {
        $this->checkFeature('asset_edit');
        return view('assets.edit', compact('asset'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $this->checkFeature('asset_edit');
        $validated = $request->validated();
        $validated['purchase_date'] = Carbon::parse($request->purchase_date)->toDateString();
        
        $asset->update($validated);

        $target = \Route::has('assets.list') ? route('assets.list') : route('dashboard');
        return redirect($target)->with('success', 'Asset updated successfully');
    }

    public function destroy(Asset $asset)
    {
        $this->checkFeature('asset_delete');
        $asset->delete();
        
        $target = \Route::has('assets.list') ? route('assets.list') : route('dashboard');
        return redirect($target)->with('success', 'Asset deleted');
    }

    public function checkId(Request $request)
    {
        if (!config('features.asset_create') && !config('features.asset_edit')) {
            abort(404);
        }
        $assetId = $request->query('asset_id');
        $currentId = $request->query('current_id'); 

        $exists = Asset::where('asset_id', $assetId)
            ->when($currentId, function ($query) use ($currentId) {
                return $query->where('id', '!=', $currentId);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}
