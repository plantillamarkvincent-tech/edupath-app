<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAboutController extends Controller
{
    public function edit(): View
    {
        $about = AboutPage::first() ?? new AboutPage([
            'title' => 'About Us',
        ]);

        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'map_embed_url' => ['nullable', 'string'],
        ]);

        $about = AboutPage::first();
        if (! $about) {
            $about = new AboutPage();
        }

        $about->fill($data);
        $about->save();

        return redirect()
            ->route('admin.about.edit')
            ->with('success', 'About Us page updated successfully.');
    }
}
