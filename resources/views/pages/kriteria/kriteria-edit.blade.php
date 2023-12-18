

@extends('layouts.admin.dashboard')
@push('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <form class="card-body form-repeater" action="{{ route('kriteria.update', $kriteria->kriteria_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Periode</label>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="tahun" style="width: 100%;">
                            <option selected="selected">--- Pilih Periode ---</option>
                            @foreach ($periode as $data)
                            <option value="{{ $data->tahun }}" @if (old('periode', $kriteria->tahun) == $data->tahun)
                                selected @endif >{{ $data->tahun }}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Nama Kriteria</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-signature"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama kriteria"
                          aria-describedby="basic-icon-default-fullname2"
                          name="nama_kriteria"
                          value="{{ $kriteria->nama_kriteria }}"
                        />
                      </div>
                    </div>
                  </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Kode Kriteria</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-signature"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama kriteria"
                          aria-describedby="basic-icon-default-fullname2"
                          name="kode_kriteria"
                          value="{{ $kriteria->kode_kriteria }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Atribut</label>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="atribut" style="width: 100%;">
                            <option selected="selected">--- Pilih Atribut ---</option>
                            <option value="benefit" {{ $kriteria->atribut === 'benefit' ? 'selected' : '' }} data-icon="ti ti-api-app" selected>Benefit</option>
                            <option value="cost" {{ $kriteria->atribut === 'cost' ? 'selected' : '' }} data-icon="ti ti-api-app">Cost</option>
                          </select>
                    </div>
                  </div>
              <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
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
        function initializeSelect2() {
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    }
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
