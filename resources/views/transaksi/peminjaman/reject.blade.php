{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('rejectPinjam') }}" method="post">
    <div class="modal-body">
        @csrf
        {{-- @method('POST') --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h5>Are you sure you want to Reject {{ $getDataPinjaman->peminjaman_keterangan }} ?</h5>
                    <input type="hidden" name="peminjaman_id" value="{{ $getDataPinjaman->peminjaman_id }}">
                </div>
                <div class="col-12">
                    <p>Keterangan reject :</p>
                    <textarea class="form-control" name="rejectKeterangan" style="width: 370px; height: 150px;"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes</button>
    </div>
</form>
