<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campus;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
class CampusController extends Controller
{
    public function viewCampuses()
    {
        $campuses = Campus::with(['users' => function($query) {
            $query->select('id', 'campus_id', 'clearances_status');
        }])->get(); // Eager load users

        foreach ($campuses as $campus) {
            $campus->completeCount = $campus->users->where('clearances_status', 'complete')->count();
            $campus->pendingCount = $campus->users->where('clearances_status', 'pending')->count();
        }

        $totalUsers = User::count();
        return view('admin.views.campus-management', compact('campuses', 'totalUsers'));
    }

    public function show($id)
    {
        $campus = Campus::with(['departments.programs'])->findOrFail($id);

        return view('admin.views.campuses.edit-campus', compact('campus'));
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

    public function addProgram(Request $request, $campusId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $program = new Program();
        $program->name = $request->name;
        $program->description = $request->description;
        $program->campus_id = $campusId; // Associate with campus
        $program->save();

        return redirect()->route('admin.campuses.show', $campusId)->with('success', 'Program added successfully.');
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
