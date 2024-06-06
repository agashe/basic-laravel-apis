<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $timesheet = Timesheet::query();

        if ($request->has('name')) {
            $timesheet->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('user_id')) {
            $timesheet->where('department', 'like', "%{$request->department}%");
        }

        if ($request->has('project_id')) {
            $timesheet->where('start_date', '=', $request->start_date);
        }

        if ($request->has('date')) {
            $timesheet->where('date', '=', $request->date);
        }

        if ($request->has('hours')) {
            $timesheet->where('hours', '=', $request->hours);
        }

        return response()->json([
            'timesheets' => $timesheet->get(),
        ]);
    }

    /**
     * Store new resource.
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data['user_id'] = auth()->user()->id;

        $timesheet = Timesheet::create($data);

        return response()->json([
            'timesheet' => $timesheet,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'timesheet' => Timesheet::findOrFail($id),
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
            'date' => 'required|date',
            'hours' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        Timesheet::findOrFail($id)->update($data);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Timesheet::findOrFail($id)->delete();

        return response()->noContent();
    }
}
