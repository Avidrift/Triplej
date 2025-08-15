<?php

namespace App\Http\Controllers;

use App\Models\Literacy_Hour;
use App\Models\Student;
use App\Models\Zone;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiteracyHourController extends Controller
{
    // Panel de profesores: registrar horas
    public function createForTeacher()
    {
        $zones = Zone::all();
        $students = Student::all();
        return view('literacy_hours.create_teacher', compact('zones', 'students'));
    }

    public function storeForTeacher(Request $request)
    {
        $request->validate([
            'id_zone' => 'required|exists:zones,id',
            'id_student' => 'required|exists:students,id',
            'date_time_start' => 'required|date',
            'date_time_end' => 'required|date|after_or_equal:date_time_start',
            'comments' => 'nullable|string',
        ]);
        Literacy_Hour::create([
            'id_zone' => $request->id_zone,
            'id_student' => $request->id_student,
            'id_teacher' => Auth::id(),
            'date_time_start' => $request->date_time_start,
            'date_time_end' => $request->date_time_end,
            'validated' => true,
            'comments' => $request->comments,
        ]);
        return redirect()->back()->with('success', 'Hora registrada correctamente.');
    }

    // Panel de estudiantes: registrar horas
    public function createForStudent()
    {
        $zones = Zone::all();
        return view('literacy_hours.create_student', compact('zones'));
    }

    public function storeForStudent(Request $request)
    {
        $request->validate([
            'id_zone' => 'required|exists:zones,id',
            'date_time_start' => 'required|date',
            'date_time_end' => 'required|date|after_or_equal:date_time_start',
            'comments' => 'nullable|string',
        ]);
        Literacy_Hour::create([
            'id_zone' => $request->id_zone,
            'id_student' => Auth::id(),
            'date_time_start' => $request->date_time_start,
            'date_time_end' => $request->date_time_end,
            'validated' => false,
            'comments' => $request->comments,
        ]);
        return redirect()->back()->with('success', 'Hora enviada para aprobación.');
    }

    // Panel de profesores: aprobar horas
    public function approveList()
    {
        $pending = Literacy_Hour::where('validated', false)->get();
        return view('literacy_hours.approve_list', compact('pending'));
    }

    public function approve($id)
    {
        $hour = Literacy_Hour::findOrFail($id);
        $hour->validated = true;
        $hour->save();
        return redirect()->back()->with('success', 'Hora aprobada.');
    }

    // Panel de profesores: monitoreo de grupos
    public function groupMonitor()
    {
        $groups = Zone::with(['students.literacyHours'])->get();
        return view('literacy_hours.group_monitor', compact('groups'));
    }

    // Panel de estudiantes: ver avance
    public function studentProgress()
    {
        $student = Auth::user();
        $total = Literacy_Hour::where('id_student', $student->id)->where('validated', true)->sum('date_time_end') - Literacy_Hour::where('id_student', $student->id)->where('validated', true)->sum('date_time_start');
        // Aquí puedes calcular el porcentaje según las horas requeridas
        return view('literacy_hours.progress', compact('total'));
    }
}
