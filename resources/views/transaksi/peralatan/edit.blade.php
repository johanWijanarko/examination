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
                        <h4 class="card-title">Edit Transaksi Alat Kantor</h4><br>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('update_trs_atk', $detail->trs_id) }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Kode Transaksi</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $detail->trs_kode }}" placeholder="" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Keterangan</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="keterangan" id="keterangan" class="form-control"  value="{{ $detail->trs_keterangan }}" placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Tanggal</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="tgl" id="tgl" class="form-control" value="{{ date("d-m-Y", strtotime($detail->trs_date) )  }}" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <button type="button" class="add-new btn btn-info" id="addBtn">Add Detail</button>
                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-striped table-inka" id="data_perangkat" width="100%">
                                    <thead>
                                      <tr>
                                        <th class="text-center" width="20%">Nama Alat Kantor</th>
                                        <th class="text-center" width="20%">Pegawai</th>
                                        <th class="text-center" width="20%">Gedung</th>
                                        <th class="text-center" width="20%">Ruangan</th>
                                        <th class="text-center" width="15%">Jumlah</th>
                                        <th class="text-center" width="10%">Remove</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach ($detail->trsDetail as $key=>$item)
                                        <tr id="cek{{ $key}}">
                                            <td>
                                                <select class="form-control perangkat" id="perangkat{{ $key}}" name="perangkat[]" required>
                                                    <option value="{{old('perangkat')}}">Pilih Peralatan Kantor</option>
                                                    @foreach ($dataStok as $perangkat)
                                                    <option {{ ($item->trs_detail_data_stok_id == $perangkat->data_stok_id ) ? 'selected' : ''}}  value="{{$perangkat->data_stok_id}}" >{{ $perangkat->data_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control pegawai" id="pegawai{{ $key}}" name="pegawai[]" required>
                                                    <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                                                    @foreach ($dataPegawai as $pegawai)
                                                        <option {{  ($item->trs_detail_pegawai_id ==  $pegawai->pegawai_id ) ? 'selected' : '' }} value="{{ $pegawai->pegawai_id }}">{{ $pegawai->pegawai_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control gedung" id="gedung{{ $key}}" name="gedung[]" required>
                                                    <option value="{{old('gedung')}}">Pilih Gedung</option>
                                                    @foreach ($gedung as $gdg)
                                                        <option {{  ($item->trs_detail_gedung_id ==  $gdg->data_gedung_id ) ? 'selected' : '' }}  value="{{ $gdg->data_gedung_id }}">{{ $gdg->nama_data_gedung }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control ruangan" id="ruangan{{ $key}}" name="ruangan[]" required>
                                                    <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                                                    @foreach ($ruangan as $ru)
                                                        <option {{ ($item->trs_detail_ruangan_id ==  $ru->data_ruangan_id ) ? 'selected' : '' }} value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="jml[]" id="jml" value="{{ $item->trs_detail_jumlah }}" class="form-control" placeholder="" required>
                                            </td>
                                            <td>
                                                <a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="" data-placement="top" title="delete" class="btn btn-sm btn-danger rounded-circle del" ><i class="fas fa-trash"></i></a>
                                                <input type="hidden" class="form-control" name="old[]" value="{{ $item->trs_detail_id }}" >
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/p_kantor_trans') }}" class="btn btn-info">Kembali</a>
                                    <button type="submit" id="disabled" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
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

    $.each($("#cek{{ $key}}"), function( index, value ) {
        $('.perangkat').select2(value)
        $('.pegawai').select2(value)
        $('.gedung').select2(value)
        $('.ruangan').select2(value)
        // console.log($('.perangkat').select2(value));
    });

  // Denotes total number of rows
  var rowIdx = 0;

  // jQuery button click event to add a row
  $('#addBtn').on('click', function () {

    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">
         <td class="row-index text-center" width="20%">
            <select class="form-control perangkat_insert" id="perangkat_insert${rowIdx}" name="perangkat_insert[]" required>
                <option value="{{old('perangkat')}}">Pilih Peralatan Kantor</option>
                @foreach ($dataStok as $stok)
                    <option value="{{ $stok->data_stok_id }}">{{ $stok->data_name }}</option>
                @endforeach
            </select>
         </td>
         <td class="row-index text-center" width="20%">
            <select class="form-control pegawai_insert" id="pegawai_insert${rowIdx}" name="pegawai_insert[]" required>
                <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                @foreach ($dataPegawai as $pegawai)
                    <option value="{{ $pegawai->pegawai_id }}">{{ $pegawai->pegawai_name }}</option>
                @endforeach
            </select>
        </td>
        <td width="20%">
            <select class="form-control gedung_insert" id="gedung_insert${rowIdx}" name="gedung_insert[]" required>
                <option value="{{old('gedung')}}">Pilih Gedung</option>
                @foreach ($gedung as $gdg)
                    <option value="{{ $gdg->data_gedung_id }}">{{ $gdg->nama_data_gedung }}</option>
                @endforeach
            </select>
        </td>
        <td width="20%">
            <select class="form-control ruangan_insert" id="ruangan_insert${rowIdx}" name="ruangan_insert[]" required>
                <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                @foreach ($ruangan as $ru)
                    <option value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
                @endforeach
            </select>
        </td>
        <td width="15%">
            <input type="text" name="jml_insert[]" id="jml" class="form-control" placeholder="" required>
        </td>
        <td width="10%">
            <a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="" data-placement="top" title="delete" class="btn btn-sm btn-danger rounded-circle remove" ><i class="fas fa-trash"></i></a>

        </td>
        </tr>`);

        $("#R"+rowIdx).find('.perangkat_insert').select2();
        $("#R"+rowIdx).find('.pegawai_insert').select2();
        $("#R"+rowIdx).find('.gedung_insert').select2();
        $("#R"+rowIdx).find('.ruangan_insert').select2();
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


    $('#tbody').on('click', '.del', function () {
        // Removing the current row.
        $(this).closest('tr').remove();

    });
});


$('#tgl').datepicker({
    format: 'dd-mm-yyyy',
    // startDate: '-3d'
});


    // $('#atk').on('change', function () {
    //     //  console.log($(this).val());
    //     $.ajax({
    //         url: '{{ url('transaksi_data/p_kantor_trans/gatAtk') }}',
    //         method: 'get',
    //         data: {id: $(this).val()},
    //         dataType : 'json',
    //         success: function (response) {
    //             console.log(response.kondisi)
    //             $('[name="merk"]').val(response.getMerk.nama_data_merk);
    //             $('#kondisi').val(response.kondisi.nama_data_kondisi);
    //             $('#kondisi_id').val(response.kondisi.data_kondisi_id);
    //             $('#sup').val(response.supplier.supplier_name);
    //             $('#jumlah').val(response.dataStok.data_jumlah+' Unit');


    //         }
    //     })
    // });

    // $('#bagian').on('change', function () {
    //     //  console.log($(this).val());
    //     $.ajax({
    //         url: '{{ url('transaksi_data/perangkat_trans/getSubBagian') }}',
    //         method: 'get',
    //         data: {id: $(this).val()},
    //         dataType : 'json',
    //         success: function (response) {
    //             // console.log(response)
    //             $('#subBagian').empty();
	// 			        $('#subBagian').append(new Option('- Pilih -', ''))
    //             $('#subBagian').trigger('change')

    //             response.forEach(item => {
    //                 $('#subBagian').append(new Option(item.nama, item.id))
    //             });

    //         }
    //     })
    // });

    // $('#pegawai').on('change', function () {
    //     //  console.log($(this).val());
    //     $.ajax({
    //         url: '{{ url('transaksi_data/perangkat_trans/getPegawai') }}',
    //         method: 'get',
    //         data: {id: $(this).val()},
    //         dataType : 'json',
    //         success: function (response) {
    //             console.log(response)
    //             $('#bagian_').val(response.pegawai_has_bagian.bagian_id)
    //             $('#subBagian_').val(response.pegawai_has_sub_bagian.sub_bagian_id)

    //             $('#bagian').val(response.pegawai_has_bagian.nama_bagian)
    //             $('#subBagian').val(response.pegawai_has_sub_bagian.sub_bagian_nama)


    //         }
    //     })
    // });

</script>
@endpush
