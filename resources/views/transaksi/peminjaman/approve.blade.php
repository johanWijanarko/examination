{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('aprovePinjam') }}" method="post">
    <div class="modal-body">
        @csrf
        {{-- @method('POST') --}}
        <h5 class="text-center">Are you sure you want to Approve {{ $getDataPinjaman->peminjaman_keterangan }} ?</h5>
        <input type="hidden" name="peminjaman_id" value="{{ $getDataPinjaman->peminjaman_id }}">
        <input type="hidden" name="peminjaman_kode" value="{{ $getDataPinjaman->peminjaman_kode }}">
        <input type="hidden" name="peminjamanType" value="{{ $getDataPinjaman->peminjamanType }}">
        <input type="hidden" name="peminjaman_obejk_id" value="{{ $getDataPinjaman->peminjaman_obejk_id }}">
        <input type="hidden" name="peminjaman_pegawai_id" value="{{ $getDataPinjaman->peminjaman_pegawai_id }}">
        <input type="hidden" name="peminjaman_gedung_id" value="{{ $getDataPinjaman->peminjaman_gedung_id }}">
        <input type="hidden" name="peminjaman_ruangan_id" value="{{ $getDataPinjaman->peminjaman_ruangan_id }}">
        <input type="hidden" name="peminjaman_pic_id" value="{{ $getDataPinjaman->peminjaman_pic_id }}">
        <input type="hidden" name="peminjaman_keterangan" value="{{ $getDataPinjaman->peminjaman_keterangan }}">
        <input type="hidden" name="peminjaman_jumlah" value="{{ $getDataPinjaman->peminjaman_jumlah }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes</button>
    </div>
</form>
