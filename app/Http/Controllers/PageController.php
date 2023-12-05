<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function periode() {
        $periode = PeriodeModel::all();
        return view('pages.user.periode', compact('periode'));
    }

    public function periodeCreate() {
        return view('pages.user.periode-create');
    }

    public function periodeEdit($id) {
        try {
            $periode = PeriodeModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('periode')->with('error_message_not_found', 'Data periode tidak ditemukan');
        }
        return view('pages.user.periode-edit', compact('periode'));
    }
}