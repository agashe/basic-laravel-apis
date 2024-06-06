<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::query();

        if ($request->has('name')) {
            $projects->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('department')) {
            $projects->where('department', 'like', "%{$request->department}%");
        }

        if ($request->has('start_date')) {
            $projects->where('start_date', '=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $projects->where('end_date', '=', $request->end_date);
        }

        if ($request->has('status')) {
            $projects->where('status', '=', $request->status);
        }

        return response()->json([
            'projects' => $projects->get(),
        ]);
    }

    /**
     * Store new resource.
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'department' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $project = Project::create($data);

        return response()->json([
            'project' => $project,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'project' => Project::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'department' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        Project::findOrFail($id)->update($data);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        Timesheet::where('project_id', $project->id)->delete();

        $project->delete();

        return response()->noContent();
    }
}
