@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Pegawai</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Home</a></div>
                <div class="breadcrumb-item">Edit Pegawai</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Edit Pegawai</h2>
            <form action="{{ url('pegawai/update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pegawai_id" value="{{ $data->idpeg }}">
                <input type="hidden" name="pegawai_detail_id" value="{{ $data->pegawai_detail_id }}">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Pegawai</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $data->nama_pegawai }}" disabled readonly placeholder="Name" id="names">
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" name="nip"  class="form-control" value="{{ $data->nip }}" disabled readonly placeholder="Name" id="nip">
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control" value="{{ $data->nik }}" disabled readonly placeholder="Name" id="nik">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ $data->username }}" disabled readonly placeholder="Name" id="username">
                                </div>
                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <input type="text" name="alamat_lengkap" class="form-control" value="{{ $data->alamat_lengkap }}" placeholder="Alamat Lengkap" id="alamat_lengkap">
                                </div>
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ $data->provinsi }}" placeholder="Provinsi" id="provinsi">
                                    {{-- <select class="form-control select2" name="provinsi">
                                        @foreach($provinsi as $item)
                                        <option value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <input type="text" name="kabupaten" class="form-control" value="{{ $data->kabupaten }}" placeholder="Kabupaten" id="kabupaten">
                                </div>
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control" value="{{ $data->kelurahan }}" placeholder="kelurahan" id="kelurahan">
                                </div>
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" value="{{ $data->kode_pos }}" placeholder="Kode Pos" id="kode_pos">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Telepon Pribadi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="telp_pribadi" value="{{ $data->telp_pribadi }}"  class="form-control phone-number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Telepon Keluarga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="telp_keluarga" value="{{ $data->telp_keluarga }}"  class="form-control phone-number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Struktur</label>
                                    <select class="form-control select2" name="struktur_id">
                                        @foreach($struktur as $item)
                                            <option @if($data->struktur_id == $item->struktur_id) selected @endif value="{{ $item->struktur_id }}">{{ $item->nama_struktur }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary w-100">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function edit(id) {
            $.ajax({
                type: 'get',
                url: "{{ url('user/edit') }}/" + id,
                // data:{'id':id}, 
                success: function(tampil) {
                    $('#tampildata').html(tampil);
                    $('#editModal').modal('show');
                }
            })
        }
    </script>
@endsection
