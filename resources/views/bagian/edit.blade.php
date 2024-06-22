<div class="mb-3 form-group">
    <label>Referensi</label>
    <select name="referensi_id" class="form-control">
        <option value="">Pilih Referensi Bagian</option>
        @foreach ($bagian as $item)
            <option value="{{ $item->id }}" @if($item->id === $data->referensi_id) selected @endif >{{ $item->nama }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3 form-group">
    <label>Nama Bagian</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" required>
</div>
<input type="hidden" value="{{ $data->uuid }}" name="uuid">