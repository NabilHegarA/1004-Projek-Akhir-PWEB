<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ================= ADMIN =================
    public function adminProfile()
    {
        return view('admin.profile');
    }

    public function editAdmin()
    {
        return view('admin.editprofil');
    }


    // ================= USER =================
    public function userProfile()
    {
        return view('user.profileUser');
    }

    public function editUser()
    {
        return view('user.edit-profileUser');
    }


    // ================= UPDATE PROFILE =================
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);

        // Redirect berdasarkan role
        if ($user->role == 'admin') {

            return redirect('/admin/profile')
                ->with('success', 'Profil berhasil diperbarui');

        }

        return redirect('/user/profileUser')
            ->with('success', 'Profil berhasil diperbarui');
    }


    // ================= DELETE ACCOUNT =================
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
