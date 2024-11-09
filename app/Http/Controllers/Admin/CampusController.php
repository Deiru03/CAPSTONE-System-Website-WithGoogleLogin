<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CampusController extends Controller
{
    public function viewCampuses()
    {
        $campuses = Campus::all();
        return view('admin.views.campus-management', compact('campuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        Campus::create($data);
    
        return redirect()->route('admin.views.campuses')->with('success', 'Campus added successfully.');
    }

    public function update(Request $request, Campus $campus)
    {
        if ($request->isMethod('GET')) {
            // Handle fetching campus data for editing
            Log::info('Fetching campus data for editing:', ['campus' => $campus]);
            return response()->json($campus);
        }

        // Handle the actual update
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        $campus->update($data);
    
        return redirect()->route('admin.views.campuses')->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();
        return response()->json(['success' => 'Campus deleted successfully.']);
    }
}