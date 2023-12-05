@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <form class="card-body form-repeater" action="{{ route('periode.update', $periode->periode_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <h6>1. Informasi KKN</h6>
              <div class="row g-3">
                <div class="row mb-3 mt-4">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Tahun</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-signature"></i
                        ></span>
                        <input
                          type="number"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="0"
                          aria-describedby="basic-icon-default-fullname2"
                          name="tahun"
                          value="{{ $periode->tahun }}"
                        />
                      </div>
                    </div>
                  </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label"  for="basic-icon-default-phone">Nama</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="ti ti-signature"></i
                        ></span>
                        <input
                          type="text"
                          class="form-control"
                          id="basic-icon-default-fullname"
                          placeholder="Masukan nama periode"
                          aria-describedby="basic-icon-default-fullname2"
                          name="nama"
                          value="{{ $periode->nama }}"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Deskripsi</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-message2" class="input-group-text"
                          ><i class="ti ti-text-wrap-disabled"></i
                        ></span>
                        <textarea
                          id="basic-icon-default-message"
                          class="form-control"
                          placeholder="Masukan deskripsi"
                          aria-label="Masukan deskripsi"
                          aria-describedby="basic-icon-default-message2"
                          name="keterangan"
                        >{{ $periode->keterangan }}</textarea>
                      </div>
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
