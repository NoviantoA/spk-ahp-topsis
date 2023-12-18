@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <div class="mx-4 my-4 d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex-end">
                    <div class="btn-group mr-4 mb-3 mb-md-0">
                        <form action="{{ route('alternatif.nilai.bobot') }}" method="get">
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
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kandidat</th>
                            @if ($countKriteria->count() > 0)
                            @for ($a = 1; $a <= $countKriteria->count(); $a++)
                            <th>C{{ $a }}</th>
                            @endfor
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($countKriteria as $row)
                       <tr>
                        <td>{{ $row->kode_alternatif }}</td>
                        <td>{{ $row->nama_alternatif }}</td>
                        @php
                        $kode_alternatif = $row->kode_alternatif;
                        @endphp
                            @foreach($dataKode[$kode_alternatif] as $kode_kriteria => $nilai)
                                <td>{{ $nilai }}</td>
                            @endforeach
                        <td>
                            <a href="{{ route('alternatif.nilai.bobot.edit', $row->kode_alternatif) }}" class="btn btn-sm btn-warning mx-1"><i class="bx bx-pencil me-1"></i>Edit</a>
                        </td>
                    </tr>
                       @endforeach
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
