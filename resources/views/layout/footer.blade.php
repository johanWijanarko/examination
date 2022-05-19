{{-- formdelete --}}
{!! Form::open(['class' => 'delete_form', 'method' => 'post', 'url' => '']) !!}
<input type="hidden" value="" name="data_id" class="data_id">
<input type="hidden" value="" name="sub_data_id" class="sub_data_id">
{!! Form::close() !!}
{{-- endformdelete --}}

<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; <a href="">Kementerian Pertahanan Republik Indonesia</a> 2022
    </div>
    <div class="footer-right">
        v.1.0
    </div>
</footer>


@push('page-script')
<script>
	function delete_confirm(data_id, sub_data_id, messages, url) {
		bootbox.confirm('Apakan Anda Yakin Untuk Menghapus Data '+messages+' Ini?', function(result) {
			if (result) {
				$('.data_id').val(data_id)
				$('.sub_data_id').val(sub_data_id)
				$('.delete_form').attr('action', url).submit();
			}
		});
	}
</script>
@endpush
