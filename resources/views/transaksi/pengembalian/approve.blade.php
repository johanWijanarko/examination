{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route("approveKembali",['id'=>$getData->pengembalian_id, 'trs_detail_id'=>$getData->pengembalian_trs_detail_id]) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('GET')
        <h5 class="text-center">Are you sure you want to Approve {{ $getData->pengembalian_keterangan }} ?</h5>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes</button>
    </div>
</form>
