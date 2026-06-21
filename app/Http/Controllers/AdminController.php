<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\Workshop;
use App\Models\Department;
use App\Models\Comment;
use App\Notifications\MaterialStatusNotification;

class AdminController extends Controller
{
    public function index()
    {
        // ── Table Data ──
        $users = User::select('id', 'first_name as name', 'email', 'role', 'academic_year as dept', 'status')->get();

        $courses = Course::select('id', 'title', 'code', 'instructor', 'status', 'year', 'semester')->get();

        $materials = Material::select('id', 'title', 'type', 'status', 'file_path')
            ->selectRaw("(SELECT first_name FROM users WHERE id = user_id) as uploader")
            ->selectRaw("(SELECT title FROM courses WHERE id = course_id) as course")
            ->selectRaw("DATE_FORMAT(created_at, '%b %d, %Y') as date")
            ->get();

        $workshops = Workshop::select('id', 'title', 'date', 'location', 'registered', 'status')->get();
        $departments = Department::select('id', 'name', 'students', 'courses', 'years', 'subjects')->get();

        $comments = Comment::with('user', 'course')
            ->orderBy('created_at', 'desc')
            ->get();

        // ── Real Stats for Overview ──
        $stats = [
            'total_users'        => User::count(),
            'total_courses'      => Course::count(),
            'total_materials'    => Material::count(),
            'total_workshops'    => Workshop::count(),
            'pending_materials'  => Material::where('status', 'pending')->count(),
            'pending_courses'    => Course::where('status', 'pending')->count(),
            'active_users'       => User::where('status', 'active')->count(),
            'banned_users'       => User::where('status', 'banned')->count(),
            'admin_users'        => User::where('role', 'admin')->count(),
            'student_users'      => User::where('role', 'student')->count(),
            'instructor_users'   => User::where('role', 'instructor')->count(),
        ];

        // ── Recent Activity (last 5 users + materials combined) ──
        $recentUsers     = User::latest()->take(5)->get(['id', 'first_name', 'last_name', 'role', 'created_at']);
        $recentMaterials = Material::latest()->take(5)->get(['id', 'title', 'user_id', 'created_at']);

        // ── Activity Chart (Users registered last 7 days) ──
        $activityData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = \Carbon\Carbon::now()->subDays($daysAgo);
            return [
                'day' => $date->format('D'), // Mon, Tue...
                'count' => User::whereDate('created_at', $date->toDateString())->count(),
            ];
        })->values();

        // ── Top Courses (Latest 5 courses) ──
        $topCoursesList = Course::latest()->take(5)->get(['id', 'title', 'code', 'status']);

        return view('pages.admin', compact(
            'users', 'courses', 'materials', 'workshops', 'departments',
            'stats', 'recentUsers', 'recentMaterials', 'activityData', 'topCoursesList',
            'comments'
        ));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'code'       => 'required|string|unique:courses,code',
            'instructor' => 'nullable|string|max:255',
            'year'       => 'required|integer|min:1|max:5',
            'semester'   => 'required|integer|in:1,2',
            'status'     => 'nullable|in:approved,pending,rejected',
        ]);

        $course = Course::create([
            'title'      => $request->title,
            'code'       => $request->code,
            'instructor' => $request->instructor,
            'year'       => $request->year,
            'semester'   => $request->semester,
            'status'     => $request->status ?? 'approved',
        ]);

        return response()->json(['success' => true, 'course' => $course]);
    }

    public function changeCourseStatus(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate(['status' => 'required|in:approved,rejected']);
        $course->status = $request->status;
        $course->save();

        return response()->json(['success' => true, 'status' => $course->status]);
    }

    public function deleteCourse($id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // ── Material Management ──
    public function changeMaterialStatus(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $request->validate(['status' => 'required|in:approved,rejected']);
        $material->status = $request->status;
        $material->save();

        if ($material->user) {
            $material->user->notify(new MaterialStatusNotification($material->title, $material->status));
        }

        return response()->json(['success' => true, 'status' => $material->status]);
    }

    public function deleteMaterial($id)
    {
        $material = Material::findOrFail($id);
        if ($material->user) {
            $material->user->notify(new MaterialStatusNotification($material->title, 'deleted'));
        }
        $material->delete();
        return response()->json(['success' => true]);
    }

    // ── User Management ──
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:student,instructor,admin',
            'status' => 'required|in:active,banned',
        ]);
        
        $user->update([
            'role' => $request->role,
            'status' => $request->status,
        ]);
        
        return response()->json(['success' => true, 'user' => clone $user]);
    }

    public function toggleBanUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'banned' ? 'active' : 'banned';
        $user->save();

        return response()->json(['success' => true, 'status' => $user->status]);
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // ── Workshop Management ──
    public function editWorkshop($id)
    {
        $workshop = Workshop::findOrFail($id);
        return view('pages.edit-workshop', compact('workshop'));
    }

    public function updateWorkshop(Request $request, $id)
    {
        $workshop = Workshop::findOrFail($id);
        $request->validate([
            'title'    => 'required|string|max:255',
            'date'     => 'required|date',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'time' => 'nullable|string',
            'duration' => 'nullable|integer',
            'type' => 'nullable|string',
            'instructor_name' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_slides' => 'nullable|mimes:pdf|max:10240',
            'useful_links' => 'nullable|string',
        ]);

        $data = [
            'title'    => $request->title,
            'date'     => \Carbon\Carbon::parse($request->date)->format('M d, Y'),
            'location' => $request->location,
            'capacity' => $request->capacity ?? $workshop->capacity,
            'category' => $request->category,
            'description' => $request->description,
            'time' => $request->time,
            'duration' => $request->duration,
            'type' => $request->type,
            'instructor_name' => $request->instructor_name,
            'useful_links' => $request->useful_links,
        ];

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('workshops/banners', 'public');
        }

        if ($request->hasFile('pdf_slides')) {
            $data['pdf_slides'] = $request->file('pdf_slides')->store('workshops/slides', 'public');
        }

        $workshop->update($data);

        return response()->json(['success' => true, 'workshop' => $workshop->fresh()]);
    }

    public function changeWorkshopStatus(Request $request, $id)
    {
        $workshop = Workshop::findOrFail($id);
        $request->validate(['status' => 'required|in:approved,rejected,pending']);
        $workshop->status = $request->status;
        $workshop->save();

        return response()->json(['success' => true, 'status' => $workshop->status]);
    }

    public function deleteWorkshop($id)
    {
        Workshop::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // ── Comment Management ──
    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
