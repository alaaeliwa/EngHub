<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'major'           => 'required|string',
            'other_major'     => 'nullable|string|max:255',
            'academic_year'   => 'required|string',
            'current_semester'=> 'required|string',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        $finalMajor = $request->major === 'other' ? $request->other_major : $request->major;

        $user = User::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'major'            => $finalMajor,
            'academic_year'    => $request->academic_year,
            'current_semester' => $request->current_semester,
            'role'             => 'student',
            'password'         => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Redirect admin directly to the admin panel
        if ($user->role === 'admin') {
            return redirect()->route('admin');
        }
        return redirect()->route('dashboard');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect admin directly to the admin panel
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin');
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'major'            => 'nullable|string|max:255',
            'academic_year'    => 'nullable|string|max:255',
            'current_semester' => 'nullable|string|max:255',
            'avatar'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'skills'           => 'nullable|string',
        ]);

        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->major            = $request->major;
        $user->academic_year    = $request->academic_year;
        $user->current_semester = $request->current_semester;
        
        if ($request->has('skills')) {
            $user->skills = $request->skills;
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('covers', 'public');
            $user->cover_photo = $path;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = route('reset-password', ['token' => $token, 'email' => $request->email]);
        
        // Log the link for testing purposes
        Log::info('Password reset link for ' . $request->email . ': ' . $resetLink);

        // Here we simulate an email send by redirecting back with a success message 
        // that also contains the link so you can test it directly!
        return back()->with('success', __('messages.auth_reset_link_sent') . ' <a href="'.$resetLink.'" style="text-decoration:underline; font-weight: bold;">' . __('messages.auth_reset_btn') . '</a>');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => 'Invalid or expired password reset token.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', __('messages.auth_pass_reset_success'));
    }
}
