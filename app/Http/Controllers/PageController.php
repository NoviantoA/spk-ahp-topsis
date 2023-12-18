<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\PeriodeModel;
use App\Models\RelAlternatifModel;
use App\Models\RelKriteriaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function periode() {
        $periode = PeriodeModel::all();
        return view('pages.periode.periode', compact('periode'));
    }

    public function periodeCreate() {
        return view('pages.periode.periode-create');
    }

    public function periodeEdit($id) {
        try {
            $periode = PeriodeModel::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('periode')->with('error_message_not_found', 'Data periode tidak ditemukan');
        }
        return view('pages.periode.periode-edit', compact('periode'));
    }

    public function kriteria(Request $request)
    {
        $periode = PeriodeModel::all();
        $selectedPeriode = $request->input('selected_periode', $periode->first()->tahun);
        $kriteria = KriteriaModel::when($selectedPeriode, function ($query) use ($selectedPeriode) {
            return $query->where('tahun', $selectedPeriode);
        })->get();
        return view('pages.kriteria.kriteria', compact('kriteria', 'periode', 'selectedPeriode'));
    }

    public function kriteriaCreate()
    {
        $periode = PeriodeModel::all();
        return view('pages.kriteria.kriteria-create', compact('periode'));
    }

    public function kriteriaEdit($id)
    {
        try {
            $kriteria = KriteriaModel::findOrFail($id);
            $periode = PeriodeModel::all();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('kriteria')->with('error_message_not_found', 'Data kriteria tidak ditemukan');
        }
        return view('pages.kriteria.kriteria-edit', compact('kriteria', 'periode'));
    }

    public function kriteriaNilaiBobot(Request $request)
    {
        $periode = PeriodeModel::all();
        $selectedPeriode = $request->input('selected_periode', $periode->first()->tahun);

        $kriteria = KriteriaModel::when($selectedPeriode, function ($query) use ($selectedPeriode) {
            return $query->where('tahun', $selectedPeriode);
        })->get();

        $rows = DB::table('rel_kriteria as rk')
        ->select('k.nama_kriteria', 'rk.ID1', 'rk.ID2', 'nilai')
        ->join('kriteria as k', 'k.kode_kriteria', '=', 'rk.ID1')
        ->where('rk.tahun', '=', $selectedPeriode)
            ->orderBy('ID1')
            ->orderBy('ID2')
            ->get();

        return view('pages.kriteria.kriteria-nilai-bobot', compact('kriteria', 'periode', 'selectedPeriode', 'rows'));
    }

    public function alternatif(Request $request)
    {
        $periode = PeriodeModel::all();
        $selectedPeriode = $request->input('selected_periode', $periode->first()->tahun);
        $alternatif = AlternatifModel::when($selectedPeriode, function ($query) use ($selectedPeriode) {
            return $query->where('tahun', $selectedPeriode);
        })->get();
        return view('pages.alternatif.alternatif', compact('alternatif', 'periode', 'selectedPeriode'));
    }

    public function alternatifCreate()
    {
        $periode = PeriodeModel::all();
        return view('pages.alternatif.alternatif-create', compact('periode'));
    }

    public function alternatifEdit($id)
    {
        try {
            $alternatif = AlternatifModel::findOrFail($id);
            $periode = PeriodeModel::all();
        } catch (ModelNotFoundException $e) {
            // Handle not found exception
            return redirect()->route('alternatif')->with('error_message_not_found', 'Data alternatif tidak ditemukan');
        }
        return view('pages.alternatif.alternatif-edit', compact('alternatif', 'periode'));
    }

    public function alternatifNilaiBobot(Request $request)
    {
        $periode = PeriodeModel::all();
        $selectedPeriode = $request->input('selected_periode', $periode->first()->tahun);

        $alternatif = AlternatifModel::when($selectedPeriode, function ($query) use ($selectedPeriode) {
            return $query->where('tahun', $selectedPeriode);
        })->get();

        $countKriteria = DB::table('alternatif')
        ->where('tahun', $selectedPeriode)
            ->get();


        $dataKode = $this->fetchDataForView($selectedPeriode);
        // dd($countKriteria->count());

        return view('pages.alternatif.alternatif-nilai-bobot', compact('alternatif', 'periode', 'selectedPeriode', 'countKriteria', 'dataKode'));
    }

    public function fetchDataForView($selectedPeriode)
    {
        $data = DB::table('alternatif as a')
        ->select('a.kode_alternatif', 'k.kode_kriteria', 'ra.nilai')
        ->join('rel_alternatif as ra', 'ra.kode_alternatif', '=', 'a.kode_alternatif')
        ->join('kriteria as k', 'k.kode_kriteria', '=', 'ra.kode_kriteria')
        ->where('a.tahun', '=', $selectedPeriode)
            ->orderBy('a.kode_alternatif')
            ->orderBy('k.kode_kriteria')
            ->get();

        $formattedData = array();

        foreach ($data as $row) {
            $formattedData[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
        }

        return $formattedData;
    }

    public function alternatifNilaiBobotEdit($id)
    {

        $kodeAlternatif = $id;

        $countKriteria = DB::table('alternatif')
        ->where('kode_alternatif', $kodeAlternatif)
            ->get();

        // dd($countKriteria->toArray());

        $row = AlternatifModel::where('kode_alternatif', $kodeAlternatif)->firstOrFail();

        $rows = DB::table('rel_alternatif as ra')
        ->select('ra.rel_alternatif_id', 'k.kode_kriteria', 'k.nama_kriteria', 'ra.nilai')
        ->join('kriteria as k', 'k.kode_kriteria', '=', 'ra.kode_kriteria')
        ->where('kode_alternatif', $kodeAlternatif)
            ->orderBy('k.kode_kriteria')
            ->get();
        return view('pages.alternatif.alternatif-nilai-bobot-edit', compact('row', 'rows', 'countKriteria'));
    }

    public function perhitungan(Request $request, $selectedPeriode = '2024')
    {
        $periode = PeriodeModel::all();
        $selectedPeriode = $request->input('selected_periode') ?? $selectedPeriode;
        $alternatifData = $this->getAlternatifData();

        // Fetch data based on the selected period
        $matriks = $this->getRelKriteria($selectedPeriode);
        // dd($matriks);
        $total = $this->getTotalKolom($matriks);

        // Normalize the matrix
        $normalizedMatriks = $this->normalize($matriks, $total);

        // Calculate the average
        $average = $this->getRata($normalizedMatriks);

        // Calculate the consistency measure
        $consistencyMeasure = $this->AHPConsistencyMeasure($matriks, $average);

        // dd($consistencyMeasure);

        $nRI = array(
            1 => 0,
            2 => 0,
            3 => 0.58,
            4 => 0.9,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.46,
            10 => 1.49,
            11 => 1.51,
            12 => 1.48,
            13 => 1.56,
            14 => 1.57,
            15 => 1.59
        );

        // Fetch TOPSIS hasil analisa data
        $topsisData = $this->getTopsisHasilAnalisa();

        $topsisNormalize = $this->topsisNormalize($this->getTopsisHasilAnalisa(false));

        $topsisNomalTerbobot = $this->topsisNomalTerbobot($topsisNormalize, $average);
        $topsisSolusiIdeal = $this->TOPSIS_solusi_ideal($topsisNomalTerbobot);
        $topsisJarakSolusi = $this->TOPSIS_jarak_solusi($topsisNomalTerbobot, $topsisSolusiIdeal);
        $topsisPreferensi = $this->TOPSIS_preferensi($topsisJarakSolusi);
        $topsisPreferensiJarak = $this->get_rank($topsisPreferensi);

        // Pass the data to the view
        return view('pages.perhitungan.perhitungan', compact(
            'matriks',
            'total',
            'selectedPeriode',
            'periode',
            'normalizedMatriks',
            'average',
            'consistencyMeasure',
            'topsisData',
            'topsisNormalize',
            'topsisNomalTerbobot',
            'nRI',
            'topsisSolusiIdeal',
            'topsisJarakSolusi',
            'topsisPreferensi',
            'topsisPreferensiJarak',
            'alternatifData'
        ));
    }

    public function getRelKriteria($selectedPeriode)
    {
        $rows = DB::table('rel_kriteria as rk')
        ->select('k.nama_kriteria as kriteria_name', 'rk.ID1', 'rk.ID2', 'rk.nilai')
        ->join('kriteria as k', 'k.kode_kriteria', '=', 'rk.ID1')
        ->where('rk.tahun', '=', $selectedPeriode)
            ->orderBy('rk.ID1')
            ->orderBy('rk.ID2')
            ->get();

        // dd($rows);
        $data = [];

        foreach ($rows as $row) {
            $data[$row->ID1][$row->ID2] = $row->nilai;
        }
        // dd($data);
        return $data;
    }


    public function getTotalKolom($matriks)
    {
        $total = array();

        foreach ($matriks as $key => $value) {
            foreach ($value as $k => $v) {
                $total[$k] = isset($total[$k]) ? ($total[$k] + $v) : $v;
            }
        }
        return $total;
    }

    public function normalize($matriks = [], $total = [])
    {
        foreach ($matriks as $key => $value) {
            foreach ($value as $k => $v) {
                $matriks[$key][$k] = $matriks[$key][$k] / $total[$k];
            }
        }
        return $matriks;
    }

    public function getRata($normal)
    {
        $rata = [];
        foreach ($normal as $key => $value) {
            $rata[$key] = array_sum($value) / count($value);
        }
        return $rata;
    }

    public function AHPConsistencyMeasure($matriks, $rata)
    {
        $matriks = $this->AHPMmult($matriks, $rata);
        $data = [];

        foreach ($matriks as $key => $value) {
            $data[$key] = $value / $rata[$key];
        }

        return $data;
    }

    public function AHPMmult($matriks = [], $rata = [])
    {
        $data = [];

        $rata = array_values($rata);

        foreach ($matriks as $key => $value) {
            $no = 0;
            foreach ($value as $k => $v) {
                $data[$key] = isset($data[$key]) ? ($data[$key] + ($v * $rata[$no])) : $v * $rata[$no];
                $no++;
            }
        }

        return $data;
    }

    public function getAlternatifData()
    {
        $rows = DB::table('alternatif')
        ->select('kode_alternatif', 'nama_alternatif')
        ->orderBy('kode_alternatif')
        ->get();

        $alternatifData = [];

        foreach ($rows as $row) {
            $alternatifData[$row->kode_alternatif] = $row->nama_alternatif;
        }

        return $alternatifData;
    }

    public function getKriteriaData()
    {
        $rows = DB::table('kriteria')
        ->select('kode_kriteria', 'nama_kriteria', 'atribut')
        ->orderBy('kode_kriteria')
        ->get();

        $kriteriaData = [];

        foreach ($rows as $row) {
            $kriteriaData[$row->kode_kriteria] = [
                'nama_kriteria' => $row->nama_kriteria,
                'atribut' => $row->atribut,
                'bobot' => isset($row->bobot) ? $row->bobot : null
            ];
        }

        return $kriteriaData;
    }


    public function getTopsisHasilAnalisa($echo = true)
    {
        $alternatifData = AlternatifModel::where('tahun', '=', request('selected_periode'))
        ->orderBy('kode_alternatif')
        ->get(['kode_alternatif', 'nama_alternatif'])
        ->keyBy('kode_alternatif');

        $kriteriaData = KriteriaModel::where('tahun', '=', request('selected_periode'))
        ->orderBy('kode_kriteria')
        ->get(['kode_kriteria', 'nama_kriteria', 'atribut'])
        ->keyBy('kode_kriteria');

        $ALTERNATIF = [];
        // dd($alternatifData);
        foreach ($alternatifData as $row) {
            $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
        }

        $KRITERIA = [];
        foreach ($kriteriaData as $row) {
            $KRITERIA[$row->kode_kriteria] = [
                'nama_kriteria' => $row->nama_kriteria,
                'atribut' => $row->atribut,
                'bobot' => isset($row->bobot) ? $row->bobot : null,
            ];
        }

        $r = "";
        $data = $this->getTopsisHasilAnalisaData();

        if (!$echo)
            return $data;

        $r .= "<tr><th></th>";
        $no = 1;
        foreach ($data[key($data)] as $key => $value) {
            if (!isset($KRITERIA[$key])) {
                continue;
            }
            $r .= "<th>" . $KRITERIA[$key]['nama_kriteria'] . "</th>";
            $no++;
        }

        $no = 1;
        foreach ($data as $key => $value) {
            // Skip the entire row if unknown alternatif
            if (!isset($ALTERNATIF[$key])) {
                continue;
            }

            $r .= "<tr>";
            $r .= "<th nowrap>" . $ALTERNATIF[$key] . "</th>";

            foreach ($value as $k => $v) {
                $r .= "<td>" . $v . "</td>";
            }

            $r .= "</tr>";
            $no++;
        }
        $r .= "</tr>";

        return new \Illuminate\Support\HtmlString($r);
    }


    public function getTopsisHasilAnalisaData()
    {

        $rows = DB::table('alternatif as a')
        ->select('a.kode_alternatif', 'k.kode_kriteria', 'ra.nilai')
        ->join('rel_alternatif as ra', 'ra.kode_alternatif', '=', 'a.kode_alternatif')
        ->join('kriteria as k', 'k.kode_kriteria', '=', 'ra.kode_kriteria')
        ->orderBy('a.kode_alternatif')
        ->orderBy('k.kode_kriteria')
        ->get();

        $data = [];

        foreach ($rows as $row) {
            $data[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
        }

        return $data;
    }

    public function topsisNormalize($array, $max = true)
    {
        $data = array();
        $kuadrat = array();

        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                // $kuadrat[$k] += ($v * $v);
                $kuadrat[$k] = isset($kuadrat[$k]) ? ($kuadrat[$k] + ($v * $v)) : ($v * $v);
            }
        }

        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $data[$key][$k] = $v / sqrt($kuadrat[$k]);
            }
        }

        return $data;
    }

    public function topsisNomalTerbobot($array, $bobot)
    {
        $data = [];

        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                // Check if the key exists in the $bobot array
                $bobotValue = isset($bobot[$k]) ? $bobot[$k] : 0;

                // Or you can use the null coalescing operator
                // $bobotValue = $bobot[$k] ?? 0;

                $data[$key][$k] = $v * $bobotValue;
            }
        }

        return $data;
    }

    public function TOPSIS_solusi_ideal($array)
    {
        $KRITERIA = $this->getKriteriaData();
        $data = [];

        $temp = [];

        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $temp[$k][] = $v;
            }
        }

        foreach ($temp as $key => $value) {
            $max = max($value);
            $min = min($value);
            if ($KRITERIA[$key] == 'benefit') {
                $data['positif'][$key] = $max;
                $data['negatif'][$key] = $min;
            } else {
                $data['positif'][$key] = $min;
                $data['negatif'][$key] = $max;
            }
        }

        return $data;
    }

    function TOPSIS_jarak_solusi($array, $ideal)
    {
        $temp = array();
        $arr = array();
        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $arr['positif'][$key][$k] = pow(($v - $ideal['positif'][$k]), 2);
                $arr['negatif'][$key][$k] = pow(($v - $ideal['negatif'][$k]), 2);

                // $temp[$key]['positif'] += pow(($v - $ideal['positif'][$k]), 2);
                // $temp[$key]['negatif'] += pow(($v - $ideal['negatif'][$k]), 2);
                $temp[$key]['positif'] = isset($temp[$key]['positif']) ? ($temp[$key]['positif'] + pow(($v - $ideal['positif'][$k]), 2)) : pow(($v - $ideal['positif'][$k]), 2);
                $temp[$key]['negatif'] = isset($temp[$key]['negatif']) ? ($temp[$key]['negatif'] + pow(($v - $ideal['negatif'][$k]), 2)) : pow(($v - $ideal['negatif'][$k]), 2);
            }
            $temp[$key]['positif'] = sqrt($temp[$key]['positif']);
            $temp[$key]['negatif'] = sqrt($temp[$key]['negatif']);
        }
        return $temp;
    }

    public function TOPSIS_preferensi($array)
    {
        $KRITERIA = $this->getKriteriaData();
        $temp = [];

        foreach ($array as $key => $value) {
            $denominator = $value['positif'] + $value['negatif'];

            // Check if the denominator is zero to avoid division by zero
            if ($denominator != 0) {
                $temp[$key] = $value['negatif'] / $denominator;
            } else {
                // Handle the case where the denominator is zero (you may set a default value or handle it accordingly)
                $temp[$key] = 0;
            }
        }

        return $temp;
    }

    public function get_rank($array)
    {
        $data = $array;
        arsort($data);
        $no = 1;
        $new = [];

        foreach ($data as $key => $value) {
            $new[$key] = $no++;
        }

        return $new;
    }
}