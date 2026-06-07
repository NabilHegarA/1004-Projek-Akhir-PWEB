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
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'no_telepon' => 'required|numeric',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'no_telepon.required' => 'Nomor telepon wajib diisi.',
                'no_telepon.numeric' => 'Nomor telepon hanya boleh angka.',
            ]
        );

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
}
