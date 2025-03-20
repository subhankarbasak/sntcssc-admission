<?php

// app/Http/Controllers/SettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('can:manage-settings');
    }

    public function index()
    {
        $settings = Setting::getCachedSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::firstOrCreate();
        
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:2048',
            'icon' => 'nullable|image|max:1024',
            'language' => 'required|string|max:10',
            'date_format' => 'required|string|max:50',
            'time_format' => 'required|string|max:50',
            'currency_symbol' => 'required|string|max:10',
            'copyright_text' => 'nullable|string|max:255',
            'maintenance_mode' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::delete($settings->logo);
            }
            $validated['logo'] = $request->file('logo')->store('public/settings');
        }

        if ($request->hasFile('icon')) {
            if ($settings->icon) {
                Storage::delete($settings->icon);
            }
            $validated['icon'] = $request->file('icon')->store('public/settings');
        }

        $settings->update($validated);

        return redirect()->back()
            ->with('success', 'Settings updated successfully')
            ->with('maintenance_notice', $settings->maintenance_mode 
                ? 'Maintenance mode is now active' 
                : 'Maintenance mode is now disabled');
    }
}