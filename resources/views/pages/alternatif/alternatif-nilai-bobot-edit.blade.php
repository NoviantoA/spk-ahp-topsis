@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <form class="card-body form-repeater" action="{{ route('alternatif.nilai.bobot.update', $row->kode_alternatif) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put') <!-- Use 'put' instead of 'post' for update -->

                <div class="row g-3">
                    <div class="row mb-3 mt-4">
                        <h6>Ubah Nilai Bobot &raquo; <small>{{ $row->nama_alternatif }}</small></h6>
                    </div>
                    @foreach($rows as $kriteria)
                        <div class="form-group">
                            <label>{{ $kriteria->nama_kriteria }}</label>
                            <input class="form-control" type="number" min="1" max="10" name="rel_alternatif_id-{{ $kriteria->rel_alternatif_id }}" value="{{ $kriteria->nilai }}" />
                        </div>
                    @endforeach
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </form>
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
