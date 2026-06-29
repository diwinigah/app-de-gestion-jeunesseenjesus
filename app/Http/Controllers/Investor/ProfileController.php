<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $investor = Auth::guard('investor')->user();

        return view('investor.profile', compact('investor'));
    }

    public function update(Request $request)
    {
        $investor = Auth::guard('investor')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email n\'est pas valide.',
        ]);

        $investor->update([
            'name' => $request->name,
            'organization_name' => $request->organization_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('investor.profile')
            ->with('success', 'Vos informations ont ete mises a jour.');
    }
}
