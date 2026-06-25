<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Notifications\AdminMaterialUploadedNotification;
use App\Notifications\AdminWorkshopCreatedNotification;

class MainController extends Controller
{
    public function home(){
        return view('pages.home');
    }
    public function login(){
        return view('pages.auth.login');
    }
    public function register(){
        $departments = \App\Models\Department::all();
        return view('pages.auth.register', compact('departments'));
    }
    public function forgotPassword(){
        return view('pages.auth.forgot-password');
    }
    public function resetPassword($token, Request $request){
        return view('pages.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }
    public function courses(Request $request){
        $year     = $request->query('year');
        $semester = $request->query('semester');

        $courses = \App\Models\Course::where('status', 'approved')
            ->withCount('materials')
            ->with(['materials.user'])
            ->when($year,     fn($q) => $q->where('year', $year))
            ->when($semester, fn($q) => $q->where('semester', $semester))
            ->orderBy('year')
            ->orderBy('semester')
            ->orderBy('title')
            ->paginate(12)->withQueryString();

        // Distinct years and semesters for filter buttons
        $allYears     = \App\Models\Course::where('status','approved')->distinct()->orderBy('year')->pluck('year');
        $allSemesters = \App\Models\Course::where('status','approved')->distinct()->orderBy('semester')->pluck('semester');

        // Top 5 Contributors (users with most materials uploaded)
        $topContributors = \App\Models\User::withCount(['materials' => function($q) {
                $q->where('status', 'approved');
            }])
            ->having('materials_count', '>', 0)
            ->orderByDesc('materials_count')
            ->take(5)
            ->get();

        return view('pages.courses', compact('courses', 'allYears', 'allSemesters', 'year', 'semester', 'topContributors'));
    }
    public function courseDetails(Request $request){
        $courseId  = $request->query('id');
        $course    = $courseId ? \App\Models\Course::with('departments')->find($courseId) : \App\Models\Course::first();
        $materials = $course
            ? $course->materials()
                ->with('user')
                ->withAvg('ratings', 'rating')
                ->withCount('ratings')
                ->latest()
                ->get()
            : collect();
        $comments  = $course ? $course->comments()->get() : collect();

        // Contributors: unique users who uploaded materials for this course
        $contributors = $materials->pluck('user')->filter()->unique('id')->values();

        $topContributors = collect();
        if ($course) {
            $topContributors = \App\Models\User::whereHas('materials', function($q) use ($course) {
                $q->where('course_id', $course->id)->where('status', 'approved');
            })->withCount(['materials' => function($q) use ($course) {
                $q->where('course_id', $course->id)->where('status', 'approved');
            }])->where('role', '!=', 'admin')
               ->having('materials_count', '>', 0)
               ->orderByDesc('materials_count')
               ->take(5)
               ->get();
        }

        return view('pages.course-details', compact('course', 'materials', 'comments', 'contributors', 'topContributors'));
    }
    public function dashboard(Request $request){
        $user = auth()->user();

        // Get max years for user's major, default to 5
        $dept = \App\Models\Department::where('name', $user->major)->first();
        $maxYears = $dept ? $dept->years : 5;

        // Use requested year if valid, else user's academic year, else 1
        $selectedYear = $request->query('year');
        if (!$selectedYear || $selectedYear < 1 || $selectedYear > $maxYears) {
            $selectedYear = $user->academic_year ?: 1;
        }

        // Courses for selected year AND user's current semester
        $courses = \App\Models\Course::where('status', 'approved')
            ->withCount('materials')
            ->where('year', $selectedYear)
            ->when($user->current_semester, fn($q) => $q->where('semester', $user->current_semester))
            ->orderBy('title')
            ->take(6)
            ->get();

        // Stats
        $uploadedCount   = \App\Models\Material::where('user_id', $user->id)->count();
        $workshopsCount  = \App\Models\WorkshopRegistration::where('user_id', $user->id)->count();
        $coursesCount    = $courses->count();

        // Recent materials uploaded by the user
        $recentUploads = \App\Models\Material::where('user_id', $user->id)
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming workshops (approved, future date, not full)
        $upcomingWorkshops = \App\Models\Workshop::where('status', 'approved')
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('pages.dashboard', compact(
            'user', 'courses', 'uploadedCount', 'workshopsCount',
            'coursesCount', 'recentUploads', 'upcomingWorkshops',
            'maxYears', 'selectedYear'
        ));
    }
    public function workshops(){
        $workshops = \App\Models\Workshop::where('status', 'approved')->orderBy('id', 'desc')->paginate(6);
        return view('pages.workshops', compact('workshops'));
    }
    public function upload(Request $request){
        $courses = \App\Models\Course::where('status', 'approved')->orderBy('year')->orderBy('semester')->orderBy('title')->get();
        $selectedCourseId = $request->query('course_id');
        return view('pages.upload', compact('courses', 'selectedCourseId'));
    }
    public function uploadSuccess(){
        return view('pages.upload-success');
    }
    public function favorites(){
        $favorites = auth()->user()->favorites()->with('course', 'user')->paginate(10);
        return view('pages.favorites', compact('favorites'));
    }
    public function profile(){
        $user = auth()->user();
        $materials = \App\Models\Material::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('pages.profile', compact('user', 'materials'));
    }
    public function createWorkshop(){
        $departments = \App\Models\Department::all();
        return view('pages.create-workshop', compact('departments'));
    }
    public function workshopDetails($id){
        $workshop = \App\Models\Workshop::with('registeredUsers')->findOrFail($id);
        $isRegistered = auth()->check() ? $workshop->isRegistered(auth()->id()) : false;
        return view('pages.workshop-details', compact('workshop', 'isRegistered'));
    }

    public function registerWorkshop($id){
        $workshop = \App\Models\Workshop::findOrFail($id);

        if (auth()->id() == $workshop->user_id) {
            return response()->json(['success' => false, 'message' => 'You cannot register for your own workshop.']);
        }

        if ($workshop->isFull()) {
            return response()->json(['success' => false, 'message' => 'Workshop is full!']);
        }

        if ($workshop->isRegistered(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Already registered!']);
        }

        \App\Models\WorkshopRegistration::create([
            'workshop_id' => $workshop->id,
            'user_id'     => auth()->id(),
        ]);

        $workshop->increment('registered');

        auth()->user()->notify(new \App\Notifications\WorkshopRegisteredNotification($workshop));

        return response()->json(['success' => true, 'registered' => $workshop->fresh()->registered]);
    }

    public function removeAttendee($workshop_id, $user_id) {
        $workshop = \App\Models\Workshop::findOrFail($workshop_id);

        if (auth()->id() != $workshop->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $registration = \App\Models\WorkshopRegistration::where('workshop_id', $workshop_id)
            ->where('user_id', $user_id)
            ->first();

        if ($registration) {
            $registration->delete();
            if ($workshop->registered > 0) {
                $workshop->decrement('registered');
            }

            $user = \App\Models\User::find($user_id);
            if ($user) {
                $user->notify(new \App\Notifications\WorkshopAttendeeRemovedNotification($workshop));
            }

            return response()->json(['success' => true, 'message' => 'Attendee removed.']);
        }

        return response()->json(['success' => false, 'message' => 'Registration not found.'], 404);
    }

    /**
     * Handle real material upload and notify all admins.
     */
    public function storeUpload(Request $request){
        $request->validate([
            'title'     => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'type'      => 'nullable|string|max:50',
            'file'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,zip,mp4|max:51200',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        $material = Material::create([
            'title'     => $request->title,
            'course_id' => $request->course_id,
            'user_id'   => auth()->id(),
            'type'      => $request->type ?? 'pdf',
            'status'    => 'pending',
            'file_path' => $filePath,
        ]);

        // Notify all admin users
        $uploaderName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminMaterialUploadedNotification(
                $uploaderName,
                $material->title,
                $material->id
            ));
        }

        return redirect()->route('upload.success');
    }

    public function storeWorkshop(Request $request){
        $request->validate([
            'title'           => 'required|string|max:255',
            'date'            => 'required|date',
            'location'        => 'required|string|max:255',
            'category'        => 'nullable|string',
            'description'     => 'nullable|string',
            'time'            => 'nullable|string',
            'duration'        => 'nullable|integer',
            'type'            => 'nullable|string',
            'instructor_name' => 'nullable|string',
            'capacity'        => 'nullable|integer',
            'banner'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_slides'      => 'nullable|mimes:pdf|max:10240',
            'useful_links'    => 'nullable|string',
            'departments'     => 'nullable|array',
            'departments.*'   => 'exists:departments,id',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('workshops/banners', 'public');
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_slides')) {
            $pdfPath = $request->file('pdf_slides')->store('workshops/slides', 'public');
        }

        $workshop = \App\Models\Workshop::create([
            'title'           => $request->title,
            'date'            => $request->date,
            'location'        => $request->location,
            'category'        => $request->category,
            'description'     => $request->description,
            'time'            => $request->time,
            'duration'        => $request->duration,
            'type'            => $request->type,
            'instructor_name' => $request->instructor_name,
            'capacity'        => $request->capacity ?? 50, // default capacity
            'banner'          => $bannerPath,
            'pdf_slides'      => $pdfPath,
            'useful_links'    => $request->useful_links,
            'user_id'         => auth()->id(),
        ]);

        if ($request->has('departments')) {
            $workshop->departments()->attach($request->departments);
        }

        // Notify all admin users
        $creatorName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminWorkshopCreatedNotification(
                $creatorName,
                $workshop->title,
                $workshop->id
            ));
        }

        return response()->json(['success' => true]);
    }
}
