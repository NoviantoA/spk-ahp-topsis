<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\PeriodeModel;
use App\Models\RelAlternatifModel;
use App\Models\RelKriteriaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function kriteriaStore(Request $request)
    {
        $data = $request->all();

        $rules = [
            'tahun' => 'required|numeric',
            'nama_kriteria' => 'required',
            'kode_kriteria' => 'required',
            'atribut' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun periode harus diisi!!!',
            'tahun.numeric' => 'Tahun periode harus tidak sesuai format (Harus angka)!!!',
            'nama_kriteria.required' => 'Nama kriteria harus diisi!!!',
            'kode_kriteria.required' => 'Kode kriteria harus diisi!!!',
            'atribut.required' => 'Atribut harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $kriteria = KriteriaModel::create([
                'tahun' => $data['tahun'],
                'kode_kriteria' => $data['kode_kriteria'],
                'nama_kriteria' => $data['nama_kriteria'],
                'atribut' => $data['atribut'],
            ]);

            // Insert into tb_rel_kriteria
            $kode = $data['kode_kriteria'];
            $PERIODE = $data['tahun'];

            // Insert into tb_rel_kriteria
            RelKriteriaModel::insertUsing(
                ['tahun', 'ID1', 'ID2', 'nilai'],
                function ($query) use ($PERIODE, $kode) {
                    $query->from('kriteria')
                    ->selectRaw("'$PERIODE' as tahun, '$kode' as ID1, kode_kriteria as ID2, 1 as nilai")
                    ->where('tahun', $PERIODE);

                    // Union to include both SELECT statements
                    $query->union(
                        $query->newQuery()
                            ->from('kriteria')
                            ->selectRaw("'$PERIODE' as tahun, kode_kriteria as ID1, '$kode' as ID2, 1 as nilai")
                            ->where('kode_kriteria', '<>', $kode)
                            ->where('tahun', $PERIODE)
                    );
                }
            );
            // Insert into tb_rel_alternatif
            RelAlternatifModel::insertUsing(
                ['tahun', 'kode_alternatif', 'kode_kriteria', 'nilai'],
                function ($query) use ($PERIODE, $kode) {
                    $query->from('alternatif')
                    ->selectRaw("'$PERIODE' as tahun, kode_alternatif, '$kode' as kode_kriteria, 1 as nilai")
                    ->where('tahun', $PERIODE);
                }
            );

            Session::flash('success_message_create', 'Data kriteria berhasil disimpan');
            return redirect()->route('kriteria');
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

    public function kriteriaUpdate(Request $request, string $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('kriteria')->with('error_message_not_found', 'Data kriteria tidak ditemukan');
        }

        $rules = [
            'tahun' => 'required|numeric',
            'nama_kriteria' => 'required',
            'atribut' => 'required',
            'kode_kriteria' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun harus diisi!!!',
            'tahun.numeric' => 'Tahun harus tidak sesuai format (Harus angka)!!!',
            'nama_kriteria.required' => 'Nama kriteria harus diisi!!!',
            'atribut.required' => 'Atribut harus diisi!!!',
            'kode_kriteria.required' => 'Kode kriteria harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);
        $data = $request->all();

        try {
            $kriteria->tahun = $data['tahun'];
            $kriteria->nama_kriteria = $data['nama_kriteria'];
            $kriteria->atribut = $data['atribut'];
            $kriteria->kode_kriteria = $data['kode_kriteria'];
            $kriteria->save();

            Session::flash('success_message_create', 'Data kriteria berhasil diperbarui');
            return redirect()->route('kriteria');
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

    public function kriteriaDelete(string $id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $kriteria->delete();

            return redirect()->route('kriteria')->with('success_message_delete', 'Data kriteria berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('kriteria')->with('error_message_not_found', 'Data kriteria tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $errorMessage = "Tidak dapat menghapus Data kriteria karena terdapat data kriteria terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data kriteria.";
            }

            return redirect()->route('kriteria')->with('error_message_delete', $errorMessage);
        }
    }

    public function kriteriaNilaiBobotUpdate(Request $request)
    {
        $data = $request->all();

        try {
            $ID1 = $data['ID1'];
            $nilai = $data['nilai'];
            $ID2 = $data['ID2'];

            // Update tb_rel_kriteria
            RelKriteriaModel::where([
                'ID1' => $ID1,
                'ID2' => $ID2,
            ])->update(['nilai' => $nilai]);

            // Update tb_rel_kriteria with inverse ID1 and ID2
            RelKriteriaModel::where([
                'ID1' => $ID2,
                'ID2' => $ID1,
            ])->update(['nilai' => 1 / $nilai]);

            Session::flash('success_message_create', 'Data kriteria berhasil disimpan');
            return redirect()->route('kriteria.nilai.bobot');
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

    public function alternatifStore(Request $request)
    {
        $data = $request->all();

        $rules = [
            'tahun' => 'required|numeric',
            'nama_alternatif' => 'required',
            'kode_alternatif' => 'required',
            'jabatan' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun periode harus diisi!!!',
            'tahun.numeric' => 'Tahun periode harus tidak sesuai format (Harus angka)!!!',
            'nama_alternatif.required' => 'Nama alternatif harus diisi!!!',
            'kode_alternatif.required' => 'Kode alternatif harus diisi!!!',
            'Jabatan.required' => 'jabatan harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->all();
        try {
            $PERIODE = $data['tahun'];
            $kode = $data['kode_alternatif'];
            $nama = $data['nama_alternatif'];
            $jabatan = $data['jabatan'];

            AlternatifModel::create([
                'tahun' => $PERIODE,
                'kode_alternatif' => $kode,
                'nama_alternatif' => $nama,
                'jabatan' => $jabatan,
            ]);

            // Insert into rel_alternatif
            RelAlternatifModel::insertUsing(
                ['tahun', 'kode_alternatif', 'kode_kriteria', 'nilai'],
                function ($query) use ($PERIODE, $kode) {
                    $query->from('kriteria')
                    ->selectRaw("'$PERIODE' as tahun, '$kode' as kode_alternatif, kode_kriteria, 0 as nilai")
                    ->where('tahun', $PERIODE);
                }
            );
            Session::flash('success_message_create', 'Data alternatif berhasil disimpan');
            return redirect()->route('alternatif');
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

    public function alternatifUpdate(Request $request, string $id)
    {
        try {
            $alternatif = AlternatifModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('alternatif')->with('error_message_not_found', 'Data alternatif tidak ditemukan');
        }

        $rules = [
            'tahun' => 'required|numeric',
            'nama_alternatif' => 'required',
            'kode_alternatif' => 'required',
            'jabatan' => 'required',
        ];

        $customMessages = [
            'tahun.required' => 'Tahun periode harus diisi!!!',
            'tahun.numeric' => 'Tahun periode harus tidak sesuai format (Harus angka)!!!',
            'nama_alternatif.required' => 'Nama alternatif harus diisi!!!',
            'kode_alternatif.required' => 'Kode alternatif harus diisi!!!',
            'Jabatan.required' => 'jabatan harus diisi!!!',
        ];

        $this->validate($request, $rules, $customMessages);
        $data = $request->all();

        try {
            $alternatif->tahun = $data['tahun'];
            $alternatif->nama_alternatif = $data['nama_alternatif'];
            $alternatif->jabatan = $data['jabatan'];
            $alternatif->kode_alternatif = $data['kode_alternatif'];
            $alternatif->save();

            Session::flash('success_message_create', 'Data alternatif berhasil diperbarui');
            return redirect()->route('alternatif');
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

    public function alternatifDelete(string $id)
    {
        try {
            $alternatif = AlternatifModel::findOrFail($id);
            $alternatif->delete();

            return redirect()->route('alternatif')->with('success_message_delete', 'Data alternatif berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('alternatif')->with('error_message_not_found', 'Data alternatif tidak ditemukan');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                $errorMessage = "Tidak dapat menghapus Data alternatif karena terdapat data alternatif terkait di data lain.";
            } else {
                $errorMessage = "Terjadi kesalahan dalam menghapus Data alternatif.";
            }

            return redirect()->route('alternatif')->with('error_message_delete', $errorMessage);
        }
    }

    public function alternatifNilaiBobotUpdate(Request $request, $id)
    {
        $relKriteria = RelAlternatifModel::where('kode_alternatif', $id)->get();

        foreach ($relKriteria as $kriteria) {
            $rel_alternatif_id = $kriteria->rel_alternatif_id;

            $newValue = $request->input("rel_alternatif_id-$rel_alternatif_id");

            RelAlternatifModel::where('rel_alternatif_id', $rel_alternatif_id)
                ->update(['nilai' => $newValue]);
        }

        return redirect()->route('alternatif.nilai.bobot')->with('success_message', 'Data updated successfully');
    }
}