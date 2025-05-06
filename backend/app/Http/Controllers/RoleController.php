<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'system_features' => 'required|array',
            'permissions' => 'required|array',
        ]);

        Role::create([
            'name' => $request->name,
            'system_features' => json_encode($request->system_features),
            'permissions' => json_encode($request->permissions),
        ]);

        return response()->json(['message' => 'Role created successfully']);
    }
}
