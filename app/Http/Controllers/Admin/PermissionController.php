<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        $roles = Role::all();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:permissions,slug'],
            'group' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $permission = Permission::create($request->only('name', 'slug', 'group', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully.',
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:permissions,slug,'.$permission->id],
            'group' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $permission->update($request->only('name', 'slug', 'group', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully.',
            'permission' => $permission,
        ]);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $permission->roles()->detach();
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully.',
        ]);
    }

    public function assignRole(Request $request): JsonResponse
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'permission_ids' => ['required', 'array'],
            'permission_ids.*' => ['exists:permissions,id'],
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->permissions()->sync($request->permission_ids);

        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned successfully.',
            'role' => $role->load('permissions'),
        ]);
    }
}
