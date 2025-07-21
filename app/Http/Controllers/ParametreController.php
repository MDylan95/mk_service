<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;

class ParametreController extends Controller
{
    public function parametres()
    {
        $admin = auth()->user();
        return view('back.parametres', compact('admin'));
    }

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

        $admin->save();

        return redirect()->route('admin.parametres')->with('success', 'Paramètres mis à jour avec succès.');
    }

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

    public function updateCarrousel(Request $request)
    {
        foreach ([1, 2, 3] as $i) {
            $file = $request->file("slide$i");

            if ($file) {
                $slide = Carousel::where('position', $i)->first();

                // Supprimer l'ancienne image si existante
                if ($slide && $slide->image_path) {
                    if (Storage::disk('public')->exists($slide->image_path)) {
                        Storage::disk('public')->delete($slide->image_path);
                    }
                }

                // Sauvegarder la nouvelle image dans storage/app/public/carousel
                $path = $file->store('carousel', 'public');

                // Mise à jour ou création avec chemin relatif
                Carousel::updateOrCreate(
                    ['position' => $i],
                    ['image_path' => $path]
                );
            }
        }

        return back()->with('success', 'Carrousel mis à jour.');
    }
}
