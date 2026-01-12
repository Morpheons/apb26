<?php

namespace App\Http\Controllers;

use App\Models\Familles;
use App\Services\Dashboard\FamillesService;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function showFamilles(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $data['familles']= Familles::where('is_actif',true)->get();
        return view('site.contact', $data);
    }

    public function generateMessage(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'firstname' => 'required',
            'name' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::to('admin@apb.e2h.fr')->send(new ContactMail($request->all()));
        return redirect()->back()->with('success', 'Votre message a été envoyé.');
    }
}
