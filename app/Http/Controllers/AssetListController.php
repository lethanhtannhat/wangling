<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetListController extends Controller
{
    public function index(Request $request)
    {
        if (!config('features.asset_list')) {
            abort(404);
        }

        $assets = Asset::filter($request->all())
            ->sort($request)
            ->get();

        return view('assets.list', compact('assets'));
    }
}
