<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Storage;

class VolunteerController extends Controller
{

    public function index()
    {
        $volunteers = Volunteer::all()->map(function ($v) {
            if ($v->profile_image) {
                $v->profile_image = asset('storage/' . $v->profile_image);
            }
            return $v;
        });

        return response()->json([
            "data" => $volunteers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'mobile' => 'required|string',
            'status' => 'required|integer',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('volunteers', 'public');
        }

        $volunteer = Volunteer::create([
            'name' => $request->name,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'status' => $request->status,
            'profile_image' => $imagePath
        ]);

        if ($volunteer->profile_image) {
            $volunteer->profile_image = asset('storage/' . $volunteer->profile_image);
        }

        return response()->json([
            "message" => "Volunteer created",
            "data" => $volunteer
        ]);
    }

    public function show($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        return response()->json([
            "data" => $volunteer
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'mobile' => 'required|string',
            'status' => 'required|integer',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $volunteer = Volunteer::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($volunteer->profile_image) {
                Storage::disk('public')->delete($volunteer->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('volunteers', 'public');
            $volunteer->profile_image = $imagePath;
        }

        $volunteer->name = $request->name;
        $volunteer->email = $request->email;
        $volunteer->country_code = $request->country_code;
        $volunteer->mobile = $request->mobile;
        $volunteer->status = $request->status;

        $volunteer->save();

        if ($volunteer->profile_image) {
            $volunteer->profile_image = asset('storage/' . $volunteer->profile_image);
        }

        return response()->json([
            "message" => "Volunteer updated",
            "data" => $volunteer
        ]);
    }

    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        if ($volunteer->profile_image) {
            Storage::disk('public')->delete($volunteer->profile_image);
        }

        $volunteer->delete();

        return response()->json([
            "message" => "Volunteer deleted successfully"
        ]);
    }
}