<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(){
        return view('pages.home');
    }
    public function login(){
        return view('pages.auth.login');
    }
    public function register(){
        return view('pages.auth.register');
    }
    public function forgotPassword(){
        return view('pages.auth.forgot-password');
    }
    public function courses(){
        return view('pages.courses');
    }
    public function courseDetails(Request $request){
        $courseId = $request->query('id');
        $course = $courseId ? \App\Models\Course::find($courseId) : \App\Models\Course::first();
        $materials = $course ? $course->materials()->with('user')->get() : collect();
        $comments = $course ? $course->comments()->get() : collect();
        return view('pages.course-details', compact('course', 'materials', 'comments'));
    }
    public function dashboard(){
        return view('pages.dashboard');
    }
    public function workshops(){
        $workshops = \App\Models\Workshop::where('status', 'approved')->orderBy('id', 'desc')->get();
        return view('pages.workshops', compact('workshops'));
    }
    public function upload(){
        $courses = \App\Models\Course::where('status', 'approved')->orderBy('year')->orderBy('semester')->orderBy('title')->get();
        return view('pages.upload', compact('courses'));
    }
    public function uploadSuccess(){
        return view('pages.upload-success');
    }
    public function favorites(){
        $favorites = auth()->user()->favorites()->with('course', 'user')->get();
        return view('pages.favorites', compact('favorites'));
    }
    public function profile(){
        return view('pages.profile');
    }
    public function createWorkshop(){
        return view('pages.create-workshop');
    }
    public function workshopDetails($id){
        $workshop = \App\Models\Workshop::with('registeredUsers')->findOrFail($id);
        $isRegistered = auth()->check() ? $workshop->isRegistered(auth()->id()) : false;
        return view('pages.workshop-details', compact('workshop', 'isRegistered'));
    }

    public function registerWorkshop($id){
        $workshop = \App\Models\Workshop::findOrFail($id);

        if ($workshop->isFull()) {
            return response()->json(['success' => false, 'message' => 'Workshop is full!']);
        }

        if ($workshop->isRegistered(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Already registered!']);
        }

        \App\Models\WorkshopRegistration::create([
            'workshop_id' => $workshop->id,
            'user_id' => auth()->id(),
        ]);

        $workshop->increment('registered');

        return response()->json(['success' => true, 'registered' => $workshop->fresh()->registered]);
    }

    public function storeWorkshop(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'time' => 'nullable|string',
            'duration' => 'nullable|integer',
            'type' => 'nullable|string',
            'instructor_name' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_slides' => 'nullable|mimes:pdf|max:10240',
            'useful_links' => 'nullable|string',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('workshops/banners', 'public');
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_slides')) {
            $pdfPath = $request->file('pdf_slides')->store('workshops/slides', 'public');
        }

        \App\Models\Workshop::create([
            'title' => $request->title,
            'date' => \Carbon\Carbon::parse($request->date)->format('M d, Y'),
            'location' => $request->location,
            'category' => $request->category,
            'description' => $request->description,
            'time' => $request->time,
            'duration' => $request->duration,
            'type' => $request->type,
            'instructor_name' => $request->instructor_name,
            'capacity' => $request->capacity ?? 30,
            'status' => 'approved', // Auto approve or pending depending on role
            'banner' => $bannerPath,
            'pdf_slides' => $pdfPath,
            'useful_links' => $request->useful_links,
        ]);

        return response()->json(['success' => true]);
    }
}
