{{-- !-- Delete Warning Modal -->  --}}
<form action="" method="">
    {{-- <div class="modal-body"> --}}
        @csrf
        {{-- @method('POST') --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <textarea class="form-control" name="ketReject" style="width: 420px; height: 150px;" readonly>{!! $getDataPinjaman->peminjaman_ket !!}</textarea>
                </div>
            </div>
        </div>
    {{-- </div> --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
</form>
