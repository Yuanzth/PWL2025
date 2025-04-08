<form id="formStokEdit" action="{{ url('stok/' . $stok->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="barang_id">Barang</label>
        <select name="barang_id" class="form-control">
            @foreach ($barangs as $barang)
                <option value="{{ $barang->id }}" {{ $stok->barang_id == $barang->id ? 'selected' : '' }}>
                    {{ $barang->barang_nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="stok_jumlah">Jumlah Stok</label>
        <input type="number" name="stok_jumlah" class="form-control" value="{{ $stok->stok_jumlah }}" required>
    </div>

    <div class="form-group">
        <label for="stok_keterangan">Keterangan</label>
        <textarea name="stok_keterangan" class="form-control" rows="3">{{ $stok->stok_keterangan }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
