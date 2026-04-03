<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $users = User::latest()->get()->map(function ($user) {
            return [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'is_admin'   => $user->is_admin,
                'created_at' => $user->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json($users);
    }

    public function deleteUser(Request $request, $id)
    {
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($request->user()->id == $id) {
            return response()->json(['message' => 'Cannot delete yourself'], 400);
        }

        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function toggleAdmin(Request $request, $id)
    {
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $user = User::findOrFail($id);
        $user->update(['is_admin' => !$user->is_admin]);

        return response()->json([
            'message'  => 'Updated successfully',
            'is_admin' => $user->is_admin,
        ]);
    }
}
