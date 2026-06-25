<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Material;

class RatingController extends Controller
{
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $material = Material::findOrFail($id);

        Rating::updateOrCreate(
            ['material_id' => $material->id, 'user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        $avg   = $material->ratings()->avg('rating');
        $count = $material->ratings()->count();

        return response()->json([
            'success' => true,
            'avg'     => round($avg, 1),
            'count'   => $count,
        ]);
    }
}
