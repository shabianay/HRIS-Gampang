<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $employee = Employee::with(['department', 'position'])
            ->where('user_id', $user->id)
            ->first();

        return view('profile.edit', compact('user', 'employee'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $employee = Employee::where('user_id', $user->id)->first();
        if ($employee) {
            $employeeData = $request->safe()->only([
                'phone', 'address', 'bank_name', 'bank_account',
                'bank_account_name', 'npwp', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan',
            ]);

            // Hanya admin yang bisa mengubah data identitas karyawan
            if ($user->role !== 'pegawai') {
                $identityFields = $request->safe()->only([
                    'full_name', 'gender', 'birth_place', 'birth_date',
                ]);
                $employeeData = array_merge($employeeData, $identityFields);
            }

            // Sync name <-> full_name
            if ($request->filled('name')) {
                $employeeData['full_name'] = $request->input('name');
            }
            if ($request->filled('full_name')) {
                $user->name = $request->input('full_name');
            }

            $employee->update($employeeData);
        }

        $user->save();

        $route = $user->role === 'pegawai' ? 'employee.profile.edit' : 'profile.edit';

        return Redirect::route($route)->with('status', 'profile-updated');
    }

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
