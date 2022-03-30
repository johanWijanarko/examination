{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('nonaktif', $user->id) }}" method="">
    <div class="modal-body">
        @csrf
        @method('GET')
        <h5 class="text-center">Anda yakin menonaktikan User {{ $user->name }} ?</h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes </button>
    </div>
</form>