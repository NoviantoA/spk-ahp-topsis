<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CRUDController extends Controller
{
    public function periodeStore(Request $request)
    {
        $data = $request->all();

        $rules = [
            'tahun' => 'required|numeric',
            'nama' => 'required',
            'keterangan' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun harus diisi!!!',
            'tahun.numeric' => 'Tahun harus tidak sesuai format (Harus angka)!!!',
            'nama.required' => 'Nama periode harus diisi!!!',
            'keterangan.required' => 'Keterangan harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $periode = new PeriodeModel();
            $periode->tahun = $data['tahun'];
            $periode->nama = $data['nama'];
            $periode->keterangan = $data['keterangan'];
            $periode->save();

            Session::flash('success_message_create', 'Data periode berhasil disimpan');
            return redirect()->route('periode');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            } else {
                // Other database-related errors
                $errorMessage = 'Upsss Terjadi Kesalahan Silahkan Coba Lagi!!!';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }

    public function periodeUpdate(Request $request, string $id)
    {
        try {
            $periode = PeriodeModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('periode')->with('error_message_not_found', 'Data periode tidak ditemukan');
        }

        $rules = [
            'tahun' => 'required|numeric',
            'nama' => 'required',
            'keterangan' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun harus diisi!!!',
            'tahun.numeric' => 'Tahun harus tidak sesuai format (Harus angka)!!!',
            'nama.required' => 'Nama periode harus diisi!!!',
            'keterangan.required' => 'Keterangan harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);
        $data = $request->all();

        try {
            $periode->tahun = $data['tahun'];
            $periode->nama = $data['nama'];
            $periode->keterangan = $data['keterangan'];
            $periode->save();

            Session::flash('success_message_create', 'Data periode berhasil diperbarui');
            return redirect()->route('periode');
        } catch (QueryException $e) {
            // Handle the integrity constraint violation exception (duplicate entry)
            if ($e->getCode() === 23000) {
                // Duplicate entry error
                $errorMessage = 'Upppss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
            } else {
                // Other database-related errors
                $errorMessage = 'Upppss Terjadi Kesalahan. Silahkan Ulangi Lagi.';
            }

            return redirect()->back()->withInput()->withErrors([$errorMessage]);
        }
    }

    public function periodeDelete(string $id)
    {
        try {
            $periode = PeriodeModel::findOrFail($id);
            $periode->delete();

            return redirect()->route('periode')->with('success_message_delete', 'Data periode berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('periode')->with('error_message_not_found', 'Data periode tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                 $errorMessage = "Tidak dapat menghapus Data periode karena terdapat data periode terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data periode.";
            }

            return redirect()->route('periode')->with('error_message_delete', $errorMessage);
        }
    }
}