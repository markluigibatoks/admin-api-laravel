<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->defaultSort('-created_at')
            ->allowedFilters(Schema::getColumnListing('users'))
            ->allowedSorts(Schema::getColumnListing('users'))
            ->paginate();
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();

        return new UserResource($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validated();
  
        return new UserResource($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
