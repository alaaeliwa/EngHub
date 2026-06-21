<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Material;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $courses = Course::where('title', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'type' => 'Course',
                    'url' => route('course.details', ['id' => $course->id])
                ];
            });

        $materials = Material::where('title', 'like', "%{$query}%")
            ->get()
            ->map(function ($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'type' => 'Material (' . $material->type . ')',
                    'url' => '#' // We don't have a material details page yet, maybe course details?
                ];
            });

        $results = $courses->concat($materials);

        return response()->json($results);
    }
}
