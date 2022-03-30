{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('menu.destroy', $menus->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Are you sure you want to delete {{ $menus->nama_menu }} ?</h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete {{ $menus->nama_menu }}</button>
    </div>
</form>