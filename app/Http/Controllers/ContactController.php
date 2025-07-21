<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche le formulaire de contact (frontend).
     */
    public function showForm()
    {
        return view('front.contact'); // Vue formulaire frontend
    }

    /**
     * Soumission du formulaire de contact.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Votre message a bien été envoyé.');
    }

    /**
     * Liste des messages pour l’admin (backend).
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('back.message', compact('contacts'));
    }

    /**
     * Suppression d’un message (supporte AJAX).
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message supprimé avec succès.'
            ]);
        }

        return redirect()->back()->with('success', 'Message supprimé avec succès.');
    }
}
