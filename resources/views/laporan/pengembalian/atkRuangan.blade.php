@extends('layout.app',[
    
])
@section('content')
<style>
    td.detail-control{

        cursor:pointer;
        width:18px;
    }
</style>
<div class="card">
    <div class="card-header" style="text-align: center !important">
       <h5>Laporan Pengembalian Peralatan Kantor Per Ruang</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-4" style="font-size: 12px !important">
                <form action="{{ route('kem_atk_ruang') }}" action="get">
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 mt-2">*) Pilih Ruangan</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="ruangan" name="ruangan">
                            <option value="{{old('ruangan')}}">Pilih Ruangan</option>
                            <option value="">All</option>
                            @foreach ($ruangan as $ru)
                                <option value="{{ $ru->data_ruangan_id }}">{{ $ru->nama_data_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 mt-2">*) Periode Laporan</label>
                    <div class="col-sm-3">
                        <input type="text"  placeholder="Start Date" name="start" id="start" autocomplete="off" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="End Date" name="end" id="end" autocomplete="off" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12" style="text-align: center !important">
                        <button type="submit" class="btn btn-info">Show</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($datakembali == null)

@else
<div class="card">
    <div class="card-body">
        <div>
            <h5>Laporan Pengembalian Peralatan Kantor Per Ruang</h5>
        </div><br>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Objek Pengembalian</th>
                        <th>Nama Pegawai</th>
                        <th>Bagian</th>
                        <th>Sub Bagian</th>
                        <th>Ruangan</th>
                        <th>Kondisi Sebelum</th>
                        <th>Kondisi Sesudah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datakembali as $i=> $lap)
                        <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $lap->kembaliHasObjek->data_manajemen_name }}</td>
                        <td>{{ $lap->kembaliHasPegawai->pegawai_name }}</td>
                        <td>{{ $lap->kembaliHasPegawai->pegawaiHasBagian->nama_bagian }}</td>
                        <td>{{ $lap->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}</td>
                        <td>{{ $lap->kembaliHasTrs->trsHasRuangan->nama_data_ruangan }}</td>
                        <td>{{ $lap->kembaliHasKondisiSblm->nama_data_kondisi }}</td>
                        <td>{{ $lap->kembaliHasKondisiSkrg->nama_data_kondisi }}</td>
                        <td>{{ $lap->pengembalian_keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row-lg-12" style="align-content: center;">
            <form action="{{ route('kem_atk_ruang_excel') }}" method="GET" id="v_excel2">
                {{ csrf_field() }}
                <input type="hidden" value="{{ request()->start }}" name="start">
                <input type="hidden" value="{{ request()->end }}" name="end">
                <input type="hidden" value="{{ request()->ruangan }}" name="ruangan">
                <div class="d-flex justify-content-center">
                    <button type="" id="excel" class="btn btn-info">Excel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
@push('page-script')

<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script> 

<script type="text/javascript">
    $(function () {
    $("#start").datepicker({
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        onSelect: function (selected) {
            // var dt = new Date(selected);
            // dt.setDate(dt.getDate() + 1);
            // $("#end").datepicker("option", "minDate", dt);
             
        }
    });
    $("#end").datepicker({
        dateFormat: 'dd-mm-yy',
        numberOfMonths: 1,
        onSelect: function (selected) {
            // var dt = new Date(selected);
            // dt.setDate(dt.getDate() - 1);
            // $("#start").datepicker("option", "maxDate", dt);
        }
    });
});
</script>
@endpush
