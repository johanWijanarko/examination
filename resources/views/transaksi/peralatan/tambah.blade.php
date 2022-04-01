@extends('layout.app',[

])
@section('content')
<style>
  .mandatory:after {
    content:" *";
    color: red;
  }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12  stretch-card grid-margin">
                <div class="card card-img-holder">
                    <div class="card-body">
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <h4 class="card-title">Input Transaksi Alat Kantor</h4><br>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- <form method="post" action="{{ route('save_trs_aplikasi') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data"> --}}
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kode Transaksi</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $getKodeTrs }}" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Tanggal</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="tgl" id="tgl" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <button type="button" class="add-new btn btn-info" id="addBtn">Add New Income</button>
                                </div>
                            </div>
                            
                          
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Row Number</th>
                                        <th class="text-center">Remove Row</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbody">
                              
                                    </tbody>
                                  </table>
                                  
                                  
                            </div>    
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/aplikasi_trans') }}" class="btn btn-info">Kembali</a>
                                    <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<script>
$(document).ready(function () {
  
  // Denotes total number of rows
  var rowIdx = 0;

  // jQuery button click event to add a row
  $('#addBtn').on('click', function () {

    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">
         <td class="row-index text-center">
            <select class="form-control" id="ruangan" name="ruangan" required>
                <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                @foreach ($ruangan as $ru)
                    <option value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
                @endforeach
            </select>
        
         </td>
          <td class="text-center">
            <button class="btn btn-danger remove"
              type="button">Remove</button>
            </td>
          </tr>`);
  });

  // jQuery button click event to remove a row.
  $('#tbody').on('click', '.remove', function () {

    // Getting all the rows next to the row
    // containing the clicked button
    var child = $(this).closest('tr').nextAll();

    // Iterating across all the rows 
    // obtained to change the index
    child.each(function () {

      // Getting <tr> id.
      var id = $(this).attr('id');

      // Getting the <p> inside the .row-index class.
      var idx = $(this).children('.row-index').children('p');

      // Gets the row number from <tr> id.
      var dig = parseInt(id.substring(1));

      // Modifying row index.
      idx.html(`Row ${dig - 1}`);

      // Modifying row id.
      $(this).attr('id', `R${dig - 1}`);
    });

    // Removing the current row.
    $(this).closest('tr').remove();

    // Decreasing total number of rows by 1.
    rowIdx--;
  });
});


$('#tgl').datepicker({
    format: 'dd/mm/yyyy',
    // startDate: '-3d'
});

$(document).ready(function() {
    $("#pegawai").select2({ width: '300px', dropdownCssClass: "bigdrop" });
    $('#atk').select2();
    $('#gedung').select2();
    $('#ruangan').select2();
    // $('#kelompok').select2();
});

    $('#atk').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/p_kantor_trans/gatAtk') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                console.log(response.kondisi)
                $('[name="merk"]').val(response.getMerk.nama_data_merk);
                $('#kondisi').val(response.kondisi.nama_data_kondisi);
                $('#kondisi_id').val(response.kondisi.data_kondisi_id);
                $('#sup').val(response.supplier.supplier_name);
                $('#jumlah').val(response.dataStok.data_jumlah+' Unit');


            }
        })
    });

    $('#bagian').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/perangkat_trans/getSubBagian') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                // console.log(response)
                $('#subBagian').empty();
				        $('#subBagian').append(new Option('- Pilih -', ''))
                $('#subBagian').trigger('change')

                response.forEach(item => {
                    $('#subBagian').append(new Option(item.nama, item.id))
                });

            }
        })
    });

    $('#pegawai').on('change', function () {
        //  console.log($(this).val());
        $.ajax({
            url: '{{ url('transaksi_data/perangkat_trans/getPegawai') }}',
            method: 'get',
            data: {id: $(this).val()},
            dataType : 'json',
            success: function (response) {
                console.log(response)
                $('#bagian_').val(response.pegawai_has_bagian.bagian_id)
                $('#subBagian_').val(response.pegawai_has_sub_bagian.sub_bagian_id)

                $('#bagian').val(response.pegawai_has_bagian.nama_bagian)
                $('#subBagian').val(response.pegawai_has_sub_bagian.sub_bagian_nama)


            }
        })
    });



</script>
@endpush
