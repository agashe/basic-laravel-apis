<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->has('email') && !empty($request->email)) {
            $users->where('email', 'like', "%{$request->email}%");
        }

        if ($request->has('first_name') && !empty($request->first_name)) {
            $users->where('first_name', 'like', "%{$request->first_name}%");
        }

        if ($request->has('last_name') && !empty($request->last_name)) {
            $users->where('last_name', 'like', "%{$request->last_name}%");
        }

        if ($request->has('birth_date') && !empty($request->birth_date)) {
            $users->where('birth_date', '=', $request->birth_date);
        }

        if ($request->has('gender') && !empty($request->gender)) {
            $users->where('gender', '=', $request->gender);
        }

        return UserResource::collection($users->get());
    }

    /**
     * Store new resource.
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data['password'] = bcrypt($data['password']);
        unset($data['password_confirmation']);

        $user = User::create($data);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        User::findOrFail($id)->update($data);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return response()->noContent();
    }

    /**
     * Display a listing of user's projects.
     */
    public function projects(Request $request)
    {
        return ProjectResource::collection(auth()->user()->projects);
    }

    /**
     * Display a listing of user's timesheets.
     */
    public function timesheets(Request $request)
    {
        return ProjectResource::collection(auth()->user()->timesheets);
    }
}
