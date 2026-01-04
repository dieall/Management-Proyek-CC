<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = LogAktivitas::with('user');

        // Filter berdasarkan model
        if ($request->has('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter berdasarkan action
        if ($request->has('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('log-aktivitas.index', compact('logs', 'user'));
    }
}
