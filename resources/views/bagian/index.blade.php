@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>bagian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
            <div class="breadcrumb-item">Bagian</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Bagian</h2>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bagian</h4>
                        <div class="col-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Nama bagian</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $spacing = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  
                                    @endphp
                                    @foreach ($data_bagian as $item)
                                        <tr>
                                            <td>{{ $item['nama'] }}</td>
                                            <td>
                                                <button onclick="edit('{{ $item['uuid'] }}')" class="btn btn-primary"> Edit</button>
                                                <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item['uuid'] }}')"
                                                        class="btn btn-danger text-white">Hapus</a>
                                            </td>
                                        </tr>
                                        @foreach ($item['sub_bagian'] as $item1)
                                            <tr>
                                                <td>{!! $spacing !!}{{ $item1['nama'] }}</td>
                                                <td>
                                                    <button onclick="edit('{{ $item1['uuid'] }}')" class="btn btn-primary"> Edit</button>
                                                    <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item1['uuid'] }}')"
                                                            class="btn btn-danger text-white">Hapus</a>
                                                </td>
                                            </tr>
                                            @foreach ($item1['sub_bagian'] as $item2)
                                                <tr>
                                                    <td>{!! $spacing. $spacing !!}{{ $item2['nama'] }}</td>
                                                    <td>
                                                        <button onclick="edit('{{ $item2['uuid'] }}')" class="btn btn-primary"> Edit</button>
                                                        <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item2['uuid'] }}')"
                                                                class="btn btn-danger text-white">Hapus</a>
                                                    </td>
                                                </tr>
                                                @foreach ($item2['sub_bagian'] as $item3)
                                                    <tr>
                                                        <td>{!!  $spacing. $spacing. $spacing !!}{{ $item3['nama'] }}</td>
                                                        <td>
                                                            <button onclick="edit('{{ $item3['uuid'] }}')" class="btn btn-primary"> Edit</button>
                                                            <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item3['uuid'] }}')"
                                                                    class="btn btn-danger text-white">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    @foreach ($item3['sub_bagian'] as $item4)
                                                        <tr>
                                                            <td>{!!  $spacing. $spacing. $spacing.$spacing !!}{{ $item4['nama'] }}</td>
                                                            <td>
                                                                <button onclick="edit('{{ $item4['uuid'] }}')" class="btn btn-primary"> Edit</button>
                                                                <a onclick="return confirmation('Apakah anda ingin menghapus ini?', 'Hapus','bagian/delete/{{ $item4['uuid'] }}')"
                                                                        class="btn btn-danger text-white">Hapus</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('bagian/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label>Referensi</label>
                        <select name="referensi_id" class="form-control">
                            <option value="">Pilih Referensi Bagian</option>
                            @foreach ($bagian as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label>Nama Bagian</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ url('bagian/update') }}" method="post">
        @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div id="tampildata"></div>
              </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
          </div>
      </form>
    </div>
  </div>

@endsection

@section('scripts')
<script>
    function edit(id){
        $.ajax({ 
            type : 'get',
            url : "{{ url('bagian/edit')}}/"+id,
            success:function(tampil){
                $('#tampildata').html(tampil);
                $('#editModal').modal('show');
            } 
        })
    }
</script>

@endsection