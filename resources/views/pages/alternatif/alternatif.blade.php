@extends('layouts.admin.dashboard')
@section('title')
    Admin || Dashboard
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <div class="mx-4 my-4 d-flex flex-column flex-md-row justify-content-between">
                <a href="{{ route('alternatif.create') }}" class="btn btn-primary mb-3 mb-md-0">+ Tambah Alternatif</a>
                <div class="d-flex-end">
                    <div class="btn-group mr-4 mb-3 mb-md-0">
                        <form action="{{ route('alternatif') }}" method="get">
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
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                        @foreach($alternatif as $data)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $data->kode_alternatif }}</td>
                          <td>{{ $data->nama_alternatif }}</td>
                          <td>{{ $data->jabatan }}</td>
                          <td>
                            <div class="d-flex">
                                <a href="{{ route('alternatif.edit', $data->alternatif_id) }}" class="btn btn-sm btn-warning mx-1"><i class="bx bx-pencil me-1"></i>Edit</a>
                            <button  data-bs-toggle="modal"
                            data-bs-target="#onboardHorizontalImageModal{{ $data->alternatif_id }}"
                            class="btn btn-sm btn-danger"><i class="bx bx-trash me-1"></i>Delete</button>
                            </div>
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

 {{-- ====================== DELETE DATA ======================== --}}
 @foreach ($alternatif as $data)
 <div
 class="modal-onboarding modal fade animate__animated"
 id="onboardHorizontalImageModal{{ $data->alternatif_id }}"
 tabindex="-1"
 aria-hidden="true"
>
 <div class="modal-dialog modal-md" role="document">
   <div class="modal-content text-center">
     <div class="modal-header border-0">
       <button
         type="button"
         class="btn-close"
         data-bs-dismiss="modal"
         aria-label="Close"
       ></button>
     </div>
     <div class="modal-body onboarding-horizontal p-0">
       <div class="onboarding-media">
         <img
           src="../../assets/img/illustrations/boy-verify-email-light.png"
           alt="boy-verify-email-light"
           width="273"
           class="img-fluid"
           data-app-light-img="illustrations/boy-verify-email-light.png"
           data-app-dark-img="illustrations/boy-verify-email-dark.png"
         />
       </div>
       <div class="onboarding-content mb-0">
         <h4 class="onboarding-title text-body text-danger">Hapus {{ $data->nama }}</h4>
         <small class="onboarding-info">
           Dengan menghapus {{ $data->nama }}, data alternatif ini akan terhapus secara permanen.
         </small>
       </div>
     </div>
     <form method="POST" action="{{ route('alternatif.delete', $data->alternatif_id) }}">
       @csrf
       @method('DELETE')
     <div class="modal-footer border-0">
       <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
         Close
       </button>
       <button type="submit" class="btn btn-danger">Hapus</button>
     </div>
     </form>
   </div>
 </div>
</div>
@endforeach
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
