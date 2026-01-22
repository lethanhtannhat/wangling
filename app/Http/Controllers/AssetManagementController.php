<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use Carbon\Carbon;
use App\Traits\HandlesValidation;

class AssetManagementController extends Controller
{
    use HandlesValidation;

    public function create()
    {
        $asset = new Asset();
        return view('assets.form', compact('asset'));
    }

    public function store(StoreAssetRequest $request)
    {
        Asset::create($request->validated());
        return redirect()->route('assets.list')->with('success', 'Asset created successfully!');
    }

    public function edit(Asset $asset)
    {
        return view('assets.form', compact('asset'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $validated = $request->validated();
        $validated['purchase_date'] = Carbon::parse($request->purchase_date)->toDateString();
        $asset->update($validated);

        return redirect()->route('assets.list')->with('success', 'Asset updated successfully');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.list')->with('success', 'Asset deleted');
    }

    public function checkUnique(Request $request)
    {
        return $this->performUniqueCheck($request, Asset::class);
    }
}
