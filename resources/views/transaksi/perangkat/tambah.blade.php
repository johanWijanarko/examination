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
                        <h4 class="card-title">Input Transaksi Perangkat</h4><br>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('save_trs') }}" class="needs-validation-pegawai" id="save_data" enctype="multipart/form-data">
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
                                    <input type="text" name="tgl" id="tgl" autocomplete="off" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label mandatory">Perangkat</label>
                                </div>
                                <div class="col-md-5">
                                    <select class="form-control perangkat" id="perangkat" name="perangkat" required>
                                        <option value="{{old('perangkat')}}">Pilih Perangkat</option>
                                        @foreach ($dataStok as $stok)
                                            <option value="{{ $stok->data_stok_id }}">{{ $stok->data_name }}</option>
                                        @endforeach
                                    </select>
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
                                        {{-- <th class="text-center">Nama Perangkat</th> --}}
                                        <th class="text-center">Pegawai</th>
                                        <th class="text-center">Gedung</th>
                                        <th class="text-center">Ruangan</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Remove</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <a href="{{ url('transaksi_data/perangkat_trans') }}" class="btn btn-info">Kembali</a>
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

  // Denotes total number of rows
  var rowIdx = 0;

  // jQuery button click event to add a row
  $('#addBtn').on('click', function () {

    // Adding a row inside the tbody.
    $('#tbody').append(`<tr id="R${++rowIdx}">

         <td class="row-index text-center" width="20%">
            <select class="form-control pegawai" id="pegawai${rowIdx}" name="pegawai[]" required>
                <option value="{{old('pegawai')}}">Pilih Pegawai</option>
                @foreach ($dataPegawai as $pegawai)
                    <option value="{{ $pegawai->pegawai_id }}">{{ $pegawai->pegawai_name }}</option>
                @endforeach
            </select>
        </td>
        <td width="20%">
            <select class="form-control gedung" id="gedung${rowIdx}" name="gedung[]" required>
                <option value="{{old('gedung')}}">Pilih Gedung</option>
                @foreach ($gedung as $gdg)
                    <option value="{{ $gdg->data_gedung_id }}">{{ $gdg->nama_data_gedung }}</option>
                @endforeach
            </select>
        </td>
        <td width="20%">
            <select class="form-control ruangan" id="ruangan${rowIdx}" name="ruangan[]" required>
                <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                @foreach ($ruangan as $ru)
                    <option value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
                @endforeach
            </select>
        </td>
        <td width="15%">
            <input type="text" name="jml[]" id="jml" class="form-control" placeholder="" required>
        </td>
        <td width="10%">
            <a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="" data-placement="top" title="delete" class="btn btn-sm btn-danger rounded-circle remove" ><i class="fas fa-trash"></i></a>

        </td>
        </tr>`);
        $("#R"+rowIdx).find('.pegawai').select2();
        $("#R"+rowIdx).find('.perangkat').select2();
        $("#R"+rowIdx).find('.gedung').select2();
        $("#R"+rowIdx).find('.ruangan').select2();
        // console.log($("#R"+rowIdx).find('.pegawai'))
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
    format: 'dd-mm-yyyy',
    // startDate: '-3d'
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
    $("#pegawai").on("change", e => {
    // $('#pegawai').on('change', function () {
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
