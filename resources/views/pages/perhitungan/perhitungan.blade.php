@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
              <div class="row">
                <div class="mx-4 my-4 d-flex flex-column flex-md-row justify-content-between">
                    <div class="d-flex-end">
                        <div class="btn-group mr-4 mb-3 mb-md-0">
                            <form action="{{ route('perhitungan') }}" method="get">
                                <select class="form-control" name="selected_periode" onchange="this.form.submit()">
                                    @foreach ($periode as $data)
                                        <option value="{{ $data->tahun }}" {{ $data->tahun == $selectedPeriode ? 'selected' : '' }}>
                                            {{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4 mb-md-2">
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="card accordion-item active">
                            <h2 class="accordion-header" id="headingOne">
                            <small class="mx-3 fw-medium">Mengukur Konsistensi Kriteria (AHP)</small>
                        <button
                          type="button"
                          class="accordion-button"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionOne"
                          aria-expanded="true"
                          aria-controls="accordionOne">
                          Matriks Perbandingan Kriteria
                        </button>
                      </h2>

                      <div
                        id="accordionOne"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif-alternatif lokasi pada tingkat paling bawah. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik. Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (9) kebalikannya, kemudian dijumlahkan perkolom. Data matrik tersebut seperti terlihat pada tabel berikut.
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach ($matriks as $key => $value)
                                                <th class="nw">{{ $key }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matriks as $key => $value)
                                            <tr>
                                                <th class="nw">{{ $key }}</th>
                                                @foreach ($value as $k => $v)
                                                    <td>{{ round($v, 3) }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="nw">Total</th>
                                            @foreach ($total as $key => $value)
                                                <td class="text-primary">{{ round($total[$key], 3) }}</td>
                                            @endforeach
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionTwo"
                          aria-expanded="false"
                          aria-controls="accordionTwo">
                          Matriks Bobot Prioritas Kriteria
                        </button>
                      </h2>
                      <div
                        id="accordionTwo"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Setelah terbentuk matrik perbandingan maka dilihat bobot prioritas untuk perbandingan kriteria. Dengan cara membagi isi matriks perbandingan dengan jumlah kolom yang bersesuaian, kemudian menjumlahkan perbaris setelah itu hasil penjumlahan dibagi dengan banyaknya kriteria sehingga ditemukan bobot prioritas seperti terlihat pada berikut.
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            @foreach ($normalizedMatriks as $key => $value)
                                                <th class="nw">{{ $key }}</th>
                                            @endforeach
                                            <th class="nw">Bobot Prioritas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($normalizedMatriks as $key => $value)
                                            <tr>
                                                <th class="nw">{{ $key }}</th>
                                                @foreach ($value as $k => $v)
                                                    <td>{{ round($v, 3) }}</td>
                                                @endforeach
                                                <td class="text-primary">{{ round($average[$key], 3) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionThree"
                          aria-expanded="false"
                          aria-controls="accordionThree">
                          Matriks Konsistensi Kriteria
                        </button>
                    </h2>
                      <div
                        id="accordionThree"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <?php
                            $cm = $consistencyMeasure;

                            echo "<thead><tr><th></th>";
                            $no = 1;
                            foreach ($normalizedMatriks as $key => $value) {
                                echo "<th class='nw'>$key</th>";
                                $no++;
                            }
                            echo "<th>Bobot</th></tr></thead>";
                            $no = 1;
                            foreach ($normalizedMatriks as $key => $value) {
                                echo "<tr>";
                                echo "<th class='nw'>$key</th>";
                                foreach ($value as $k => $v) {
                                    echo "<td>" . round($v, 3) . "</td>";
                                }
                                echo "<td class='text-primary'>" . round($cm[$key], 3) . "</td>";
                                echo "</tr>";
                                $no++;
                            }
                            echo "</tr>";
                            ?>
                                </table>
                            </div>
                            <p>Berikut tabel ratio index berdasarkan ordo matriks.</p>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Ordo matriks</th>
                                    @foreach ($nRI as $key => $value)
                                        <td class="{{ count($matriks) == $key ? 'text-primary' : '' }}">{{ $key }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Ratio index</th>
                                    @foreach ($nRI as $key => $value)
                                        <td class="{{ count($matriks) == $key ? 'text-primary' : '' }}">{{ $value }}</td>
                                    @endforeach
                                </tr>
                            </table>
                            </div>
                            <div class="panel-footer">
                                <?php
                    $CI = ((array_sum($consistencyMeasure) / count($consistencyMeasure)) - count($consistencyMeasure)) / (count($consistencyMeasure) - 1);
                    $RI = $nRI[count($matriks)];
                    $CR = $CI / $RI;
                    echo "<p>Consistency Index: " . round($CI, 3) . "<br />";
                    echo "Ratio Index: " . round($RI, 3) . "<br />";
                    echo "Consistency Ratio: " . round($CR, 3);
                    if ($CR > 0.10) {
                        echo " (Tidak konsisten)<br />";
                    } else {
                        echo " (Konsisten)<br />";
                    }
                    ?>
                            </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-4 mb-md-2 mt-4">
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="card accordion-item active">
                            <h2 class="accordion-header" id="headingOne">
                            <small class="mx-3 fw-medium">Perhitungan TOPSIS</small>
                        <button
                          type="button"
                          class="accordion-button"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionOne1"
                          aria-expanded="true"
                          aria-controls="accordionOne1">
                          Hasil Analisa
                        </button>
                      </h2>

                      <div
                        id="accordionOne1"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    {{$topsisData}}
                                </table>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionTwo2"
                          aria-expanded="false"
                          aria-controls="accordionTwo2">
                          Normalisasi
                        </button>
                      </h2>
                      <div
                        id="accordionTwo2"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <?php

                                    $normal = $topsisNormalize;
                                    $r = "";
                                    $r .= "<tr><th></th>";
                                    $no = 1;
                                    foreach ($normal[key($normal)] as $key => $value) {
                                        $r .= "<th>$key</th>";
                                        $no++;
                                    }

                                    $no = 1;
                                    foreach ($normal as $key => $value) {
                                        $r .= "<tr>";
                                        $r .= "<th>A" . $no . "</th>";
                                        foreach ($value as $k => $v) {
                                            $r .= "<td>" . round($v, 5) . "</td>";
                                        }
                                        $r .= "</tr>";
                                        $no++;
                                    }
                                    $r .= "</tr>";
                                    echo  $r;
                                    ?>

                                </table>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionThree3"
                          aria-expanded="false"
                          aria-controls="accordionThree3">
                          Normalisasi Terbobot
                        </button>
                    </h2>
                      <div
                        id="accordionThree3"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <?php
                                    $r = "";
                                    $terbobot = $topsisNomalTerbobot;

                                    $r .= "<tr><th></th>";
                                    $no = 1;

                                    // Iterate over the columns (header)
                                    foreach ($terbobot[key($terbobot)] as $key => $value) {
                                        $r .= "<th>$key</th>";
                                        $no++;
                                    }

                                    $r .= "</tr>";

                                    $no = 1;

                                    foreach ($terbobot as $key => $value) {
                                        $rowContainsNonZero = false;

                                        // Check if any value in the row is not 0
                                        foreach ($value as $k => $v) {
                                            if ($v != 0) {
                                                $rowContainsNonZero = true;
                                                break;
                                            }
                                        }

                                        // Skip the entire row if all values are 0
                                        if ($rowContainsNonZero) {
                                            $r .= "<tr>";
                                            $r .= "<th>$key</th>";

                                            // Iterate over the columns (data)
                                            foreach ($value as $k => $v) {
                                                $r .= "<td>" . ($v != 0 ? round($v, 5) : "") . "</td>";
                                            }

                                            $r .= "</tr>";
                                            $no++;
                                        }
                                    }

                                    $r .= "</tr>";
                                    echo $r;
                                    ?>
                                </table>
                            </div>
                            </div>
                        </div>
                      </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionThree4"
                          aria-expanded="false"
                          aria-controls="accordionThree4">
                          Matriks Solusi Ideal
                        </button>
                    </h2>
                      <div
                        id="accordionThree4"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <?php
                                        $r = "";
                                        $ideal = $topsisSolusiIdeal;

                                        $r .= "<tr><th></th>";
                                        $no = 1;

                                        // Iterate over the columns (header)
                                        foreach ($ideal[key($ideal)] as $key => $value) {
                                            // Skip the column if the value is 0
                                            if ($value != 0) {
                                                $r .= "<th>" . $key . "</th>";
                                                $no++;
                                            }
                                        }

                                        $r .= "</tr>";

                                        $no = 1;

                                        // Iterate over the rows
                                        foreach ($ideal as $key => $value) {
                                            $rowContainsNonZero = false;

                                            // Check if any value in the row is not 0
                                            foreach ($value as $k => $v) {
                                                if ($v != 0) {
                                                    $rowContainsNonZero = true;
                                                    break;
                                                }
                                            }

                                            // Skip the entire row if all values are 0
                                            if ($rowContainsNonZero) {
                                                $r .= "<tr>";
                                                $r .= "<th>" . $key . "</th>";

                                                // Iterate over the columns (data)
                                                foreach ($value as $k => $v) {
                                                    // Skip the column if the value is 0
                                                    if ($v != 0) {
                                                        $r .= "<td>" . round($v, 5) . "</td>";
                                                    }
                                                }

                                                $r .= "</tr>";
                                                $no++;
                                            }
                                        }

                                        $r .= "</tr>";
                                        echo $r;
                                        ?>
                                </table>
                            </div>
                            </div>
                        </div>
                      </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionThree5"
                          aria-expanded="false"
                          aria-controls="accordionThree5">
                          Jarak Solusi & Nilai Preferensi
                        </button>
                    </h2>
                      <div
                        id="accordionThree5"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th></th>
                                        <th>Positif</th>
                                        <th>Negatif</th>
                                        <th>Preferensi</th>
                                    </tr>
                                    <?php
                                    $jarak = $topsisJarakSolusi;
                                    $pref = $topsisPreferensi;

                                    foreach ($normal as $key => $value) {
                                        $rowContainsNonZero = false;

                                        // Check if any value in the row is not 0
                                        foreach ([$jarak[$key]['positif'], $jarak[$key]['negatif'], $pref[$key]] as $v) {
                                            if ($v != 0) {
                                                $rowContainsNonZero = true;
                                                break;
                                            }
                                        }

                                        // Skip the entire row if all values are 0
                                        if ($rowContainsNonZero) {
                                            echo "<tr>";
                                            echo "<th>$key</th>";
                                            echo "<td>" . ($jarak[$key]['positif'] != 0 ? round($jarak[$key]['positif'], 5) : "") . "</td>";
                                            echo "<td>" . ($jarak[$key]['negatif'] != 0 ? round($jarak[$key]['negatif'], 5) : "") . "</td>";
                                            echo "<td>" . ($pref[$key] != 0 ? round($pref[$key], 5) : "") . "</td>";
                                            echo "</tr>";
                                            $no++;
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            </div>
                        </div>
                      </div>
                    <div class="card accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button
                          type="button"
                          class="accordion-button collapsed"
                          data-bs-toggle="collapse"
                          data-bs-target="#accordionThree6"
                          aria-expanded="false"
                          aria-controls="accordionThree6">
                          Perangkingan
                        </button>
                    </h2>
                      <div
                        id="accordionThree6"
                        class="accordion-collapse collapse"
                        aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>Rank</th>
                                    </tr>
                                    <?php
                                    $rank = $topsisPreferensiJarak;

                                    foreach ($normal as $key => $value) {
                                        // Check if total has a value and is not empty
                                        if (!empty($pref[$key]) && !empty($rank[$key])) {
                                            App\Models\AlternatifModel::query("UPDATE tb_alternatif SET total='$pref[$key]', rank='$rank[$key]' WHERE kode_alternatif='$key'");
                                            echo "<tr>";
                                            echo "<th>$key - $alternatifData[$key]</th>";
                                            echo "<td class='text-primary'>" . ($pref[$key] != 0 ? round($pref[$key], 3) : "") . "</td>";
                                            echo "<td class='text-primary'>" . ($rank[$key] != 0 ? $rank[$key] : "") . "</td>";
                                            echo "</tr>";
                                            $no++;
                                        }
                                    }
                                    ?>

                                </table>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
     <script>
        document.getElementById('viewDataLink').addEventListener('click', function() {
          var table = document.getElementById('example1');
          if (table) {
            table.scrollIntoView({ behavior: 'smooth' });
          }
        });
      </script>
@endpush
