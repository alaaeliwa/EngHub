<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();
        $material = Material::findOrFail($id);

        if ($user->favorites()->where('material_id', $id)->exists()) {
            $user->favorites()->detach($id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorites()->attach($id);
            return response()->json(['status' => 'added']);
        }
    }
}
