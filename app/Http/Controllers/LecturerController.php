<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
    $lecturers = Lecturer::with('user')
        ->withCount('courses')->where('is_activated', true)->latest()->paginate(10);

    return view('lecturers.index', compact('lecturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     $users = User::whereDoesntHave('lecturer')->get();

    return view('lecturers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'user_id' => 'required|exists:users,id|unique:lecturers,user_id',
        'employee_number' => 'required|string|unique:lecturers,employee_number',
        'department' => 'required|string|max:255',
        'academic_rank' => 'required|string|max:255',
        'office_room' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')
            ->store('lecturers', 'public');
    }

    Lecturer::create($validated);

    return redirect()
        ->route('lecturers.index')
        ->with('success', 'Lecturer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
{

        $lecturer->load('user', 'courses');

    return view('lecturers.show', compact('lecturer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        return view('lecture.edit');
    }

    /**
     * Update the specified resource in storage.
     */
  
public function update(Request $request, Lecturer $lecturer)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id|unique:lecturers,user_id,' . $lecturer->id,
        'employee_number' => 'required|string|unique:lecturers,employee_number,' . $lecturer->id,
        'department' => 'required|string|max:255',
        'academic_rank' => 'required|string|max:255',
        'office_room' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('photo')) {

        $validated['photo'] = $request->file('photo')
            ->store('lecturers', 'public');
    }

    $lecturer->update($validated);

    return redirect()
        ->route('lecturers.index')
        ->with('success', 'Lecturer updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    
public function destroy(Lecturer $lecturer)
{
    if ($lecturer->courses()->exists()) {
        return redirect()
            ->route('lecturers.index')
            ->with('error', 'Cannot delete lecturer because assigned courses exist.');
    }

    $lecturer->delete();

    return redirect()
        ->route('lecturers.index')
        ->with('success', 'Lecturer deleted successfully.');
}


