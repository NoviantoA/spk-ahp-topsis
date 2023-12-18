@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <div class="mx-4 my-4 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex-start">
                    <div class="btn-group mr-4 mb-3 mb-md-0">
                        <form action="{{ route('kriteria.nilai.bobot.update') }}" method="post" class="d-flex">
                            @csrf
                            @method('put')
                            <select class="form-control mx-1" name="ID1">
                                @foreach ($kriteria as $data)
                                    <option value="{{ $data->kode_kriteria }}" >
                                        {{ $data->nama_kriteria }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control mx-1" name="nilai">
                                <option value="1">1 - Sama Penting Dengan</option>
                                <option value="2">2 - Mendekati sedikit lebih penting dari</option>
                                <option value="3">3 - Sedikit lebih penting dari</option>
                                <option value="4">4 - Mendekati lebih penting dari</option>
                                <option value="5">5 - Lebih penting dari</option>
                                <option value="6">6 - Mendekati sangat penting dari</option>
                                <option value="7">7 - Sangat penting dari</option>
                                <option value="8">8 - Mendekati mutlak dari</option>
                                <option value="9">9 - Mutlak sangat penting dari</option>
                            </select>
                            <select class="form-control mx-1" name="ID2">
                                @foreach ($kriteria as $data)
                                    <option value="{{ $data->kode_kriteria }}" >
                                        {{ $data->nama_kriteria }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary mb-3 mb-md-0"><i class="bx bx-pencil"></i>Ubah</button>
                        </form>
                    </div>
                </div>
                <div class="d-flex-end">
                    <div class="btn-group mr-4 mb-3 mb-md-0">
                        <form action="{{ route('kriteria.nilai.bobot') }}" method="get">
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
            <!-- /.card-header -->
            <div class="card-body">
                @php
                    $criterias = array();
                    $data = array();
                    foreach ($rows as $row) {
                        $criterias[$row->ID1] = $row->nama_kriteria;
                        $data[$row->ID1][$row->ID2] = $row->nilai;
                    }
                @endphp
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <?php
                            foreach ($data as $key => $value) {
                                echo "<th>$key</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $a = 1;
                        foreach ($data as $key => $value) : ?>
                        <tr>
                            <th class="nw"><?= $key ?></th>
                            <?php
                                $b = 1;
                                foreach ($value as $k => $dt) {
                                    if ($key == $k)
                                        $class = 'success';
                                    elseif ($b > $a)
                                        $class = 'danger';
                                    else
                                        $class = '';

                                    echo "<td class='$class'>" . round($dt, 3) . "</td>";
                                    $b++;
                                }
                                $no++;
                                ?>
                        </tr>
                        <?php $a++;
                        endforeach;
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
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
@endpush
