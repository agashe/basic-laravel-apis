<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimesheetResource;
use App\Http\Resources\TimesheetDetailsResource;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $timesheet = Timesheet::query();

        if ($request->has('name') && !empty($request->name)) {
            $timesheet->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('project_id') && !empty($request->project_id)) {
            $timesheet->where('project_id', '=', $request->project_id);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $timesheet->where('user_id', '=', $request->user_id);
        }

        if ($request->has('date') && !empty($request->date)) {
            $timesheet->where('date', '=', $request->date);
        }

        if ($request->has('hours') && !empty($request->hours)) {
            $timesheet->where('hours', '=', $request->hours);
        }

        return TimesheetDetailsResource::collection($timesheet->with(['project', 'user'])->get());
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

        return new TimesheetDetailsResource($timesheet);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TimesheetDetailsResource(Timesheet::findOrFail($id));
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
