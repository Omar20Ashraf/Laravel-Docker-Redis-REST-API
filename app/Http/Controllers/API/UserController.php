<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Jobs\ProcessUserJob;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'data' => UserResource::collection(User::all())
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        ProcessUserJob::dispatch($user)->onQueue('user-processing');

        return response()->json([
            'status' => true,
            'message' => 'Created Successfully',
            'data' => [
                'data' => new UserResource($user)
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response([
            'status' => true,
            'data' => new UserResource($user),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = $request->filled('password') ? Hash::make($validatedData['password']) : $user->password;

        $user->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully',
            'data' => [
                'data' => new UserResource($user)
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully',
            'data' => [],
        ], Response::HTTP_OK);
    }
}
