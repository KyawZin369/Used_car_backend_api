<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Appointment created successfully!',
            'appointment' => $appointment,
        ], 201);
    }

    public function myAppointments(Request $request, $user_id)
{
    $appointments = Appointment::where('user_id', $user_id)
        ->get();

    return response()->json(['appointments' => $appointments]);
}

public function carAppointment(Request $request, $carId)
{
    $appointments = Appointment::where('car_id', $car_id)
        ->get();

    return response()->json(['appointments' => $appointments]);
}

    public function appointments(){
        $appointments = Appointment::all();
        return response()->json(['appointments' => $appointments], 200);
    }

}
