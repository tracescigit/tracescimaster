<?php

namespace App\Http\Controllers;

use App\Models\DemoSchedule;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index()
    {
        return view('admin.demo.index');
    }
    public function create()
    {
        // Build booked slots: ['2026-04-22' => ['09:00', '10:00'], ...]
        $bookedSlots = DemoSchedule::selectRaw('demo_date, GROUP_CONCAT(demo_time) as times')
            ->where('status', '!=', 3) // exclude cancelled
            ->groupBy('demo_date')
            ->get()
            ->mapWithKeys(fn($row) => [
                $row->demo_date => explode(',', $row->times)
            ]);
        return view('web.demo')->with('bookedSlots',$bookedSlots);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'company_name'  => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'demo_date'     => 'required|date|after_or_equal:today',
            'demo_time'     => 'required|in:09:00,10:00,11:00,14:00,15:00,16:00,17:00',
            'message'       => 'nullable|string|max:1000',
        ]);

        // Check slot isn't already taken (race condition guard)
        $exists = DemoSchedule::where('demo_date', $validated['demo_date'])
            ->where('demo_time', $validated['demo_time'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'That slot is Already Taken. Please pick another time.'
            ], 422);
        }

        $demo = DemoSchedule::create($validated);

        return response()->json(['message' => 'Demo booked successfully.']);
    }
}
