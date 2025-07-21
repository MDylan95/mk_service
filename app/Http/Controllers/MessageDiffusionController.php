<?php

namespace App\Http\Controllers;

use App\Models\MessageDiffusion;
use Illuminate\Http\Request;

class MessageDiffusionController extends Controller
{
    // Afficher le formulaire d'édition
    public function edit()
    {
        $message = MessageDiffusion::where('key', 'marquee_message')->first();

        return view('back.message_diffusion', [
            'message' => $message,
        ]);
    }

    // Mettre à jour le message
    public function update(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:500',
        ]);

        MessageDiffusion::updateOrCreate(
            ['key' => 'marquee_message'],
            ['value' => $request->value]
        );

        return redirect()->route('admin.message_diffusion.edit')
            ->with('success', 'Message de diffusion mis à jour.');
    }
}
