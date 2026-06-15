<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecializationController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialization::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $specializations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.specializations.index', compact('specializations'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:specializations,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $specialization = Specialization::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Specialization created successfully.',
            'specialization' => $specialization,
        ]);
    }

    public function show(Specialization $specialization): JsonResponse
    {
        return response()->json([
            'success' => true,
            'specialization' => $specialization,
        ]);
    }

    public function update(Request $request, Specialization $specialization): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:specializations,name,'.$specialization->id],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $specialization->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Specialization updated successfully.',
            'specialization' => $specialization,
        ]);
    }

    public function destroy(Specialization $specialization): JsonResponse
    {
        if ($specialization->doctors()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete specialization with assigned doctors.',
            ], 422);
        }

        $specialization->delete();

        return response()->json([
            'success' => true,
            'message' => 'Specialization deleted successfully.',
        ]);
    }

    public function updateStatus(Request $request, Specialization $specialization): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $specialization->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Specialization status updated successfully.',
            'specialization' => $specialization,
        ]);
    }
}
