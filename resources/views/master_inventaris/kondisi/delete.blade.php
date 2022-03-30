{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('deletekondisi', $DataKondisi->data_kondisi_id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('GET')
        <h5 class="text-center">Are you sure you want to delete {{ $DataKondisi->nama_data_kondisi }} ?</h5>
         
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete </button>
    </div>
</form>