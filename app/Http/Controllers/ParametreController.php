<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;

class ParametreController extends Controller
{
    /**
     * Affiche la page générale des paramètres.
     */
    public function parametres()
    {
        $admin = auth()->user(); // récupère l'admin connecté
        return view('back.parametres', compact('admin'));
    }

    /**
     * Met à jour les paramètres généraux (email, mot de passe, avatar).
     */
    public function updateParametres(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar si existant
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            // Sauvegarder le nouvel avatar
            $admin->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $admin->save();

        return redirect()->route('admin.parametres')->with('success', 'Paramètres mis à jour avec succès.');
    }

    /**
     * Affiche la page du carrousel.
     */
    public function carrousel()
    {
        // Initialise les 3 slides s’ils n’existent pas
        for ($i = 1; $i <= 3; $i++) {
            Carousel::firstOrCreate(
                ['position' => $i],
                ['image_path' => null]
            );
        }

        $slides = Carousel::orderBy('position')->get();
        return view('back.carousel', compact('slides'));
    }

    /**
     * Met à jour les images du carrousel.
     */
    public function updateCarrousel(Request $request)
    {
        foreach ([1, 2, 3] as $i) {
            $file = $request->file("slide$i");

            if ($file) {
                $slide = Carousel::where('position', $i)->first();

                // Supprimer l'ancienne image si existante
                if ($slide && $slide->image_path && Storage::disk('public')->exists($slide->image_path)) {
                    Storage::disk('public')->delete($slide->image_path);
                }

                // Sauvegarder la nouvelle image
                $path = $file->store('carousel', 'public');

                // Mettre à jour ou créer le slide
                Carousel::updateOrCreate(
                    ['position' => $i],
                    ['image_path' => $path]
                );
            }
        }

        return back()->with('success', 'Carrousel mis à jour.');
    }

    /**
     * Affiche la page des paramètres du compte (nom, email, mot de passe).
     */
    public function compte()
    {
        $admin = auth()->user(); // admin connecté
        return view('back.compte', compact('admin'));
    }

    /**
     * Met à jour les informations du compte de l'admin.
     */
    public function updateCompte(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:utilisateurs,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];

        if (!empty($data['password'])) {
            $admin->password = bcrypt($data['password']);
        }

        $admin->save();

        return redirect()->route('admin.parametres.compte')->with('success', 'Compte mis à jour avec succès !');
    }
}
