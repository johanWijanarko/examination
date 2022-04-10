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
       <h5>Laporan Transaksi</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-4" style="font-size: 12px !important">
                <form action="{{ route('laporanTransaksi') }}" action="get">
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
                    <label for="inputEmail3" class="col-sm-3 mt-2">*) Pilih Gedung</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="gedung" name="gedung">
                            <option value="">All</option>
                            @foreach ($gedung as $gdg)
                                <option value="{{ $gdg->data_gedung_id }}">{{ $gdg->nama_data_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                    <label for="inputEmail3" class="col-sm-3 mt-2">*)Pilih Type / Kategory</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="type" name="type">
                            <option value="{{old('type')}}">Pilih Type</option>
                            <option value="">All</option>
                            @foreach ($type as $ty)
                                <option value="{{ $ty->data_type_id }}">{{ $ty->nama_data_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 mt-2">*)Pilih Status</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="status" name="status">
                            <option value="{{old('status')}}">Pilih Status</option>
                            <option value="">All</option>
                            <option value="1">Dipakai</option>
                            <option value="2">Dipinjam</option>
                            <option value="3">Sedang diperbaiki</option>
                            <option value="4">Dikembalikan</option>
                            <option value="5">Dimutasi</option>
                            <option value="6">Selesai diperbaikai</option>
                            <option value="7">Tidak dapat diperbaik</option>

                        </select>
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
@if ($laporan == null)

@else
<div class="card">
    <div class="card-body">
        <div>
            <h5>Laporan Transaksi</h5>
        </div><br>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-inka" id="data_perangkat">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type / Kategory </th>
                        <th>Objek Transaksi </th>
                        <th>Nama Pegawai</th>
                        <th>Bagian</th>
                        <th>Sub Bagian</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $i=> $lap)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $lap->trsHasStok2->stokHasType->nama_data_type }}</td>
                            <td>{{ $lap->trsHasStok2->data_name }}</td>
                            <td>{{ $lap->trsHasPegawai2->pegawai_name }}</td>
                            <td>{{ $lap->trsHasPegawai2->pegawaiHasBagian->nama_bagian ?? '' }}</td>
                            <td>{{ $lap->trsHasPegawai2->pegawaiHasSubBagian->sub_bagian_nama ?? '' }}</td>
                            @php
                                $status = [
                                    '1' => 'Dipakai',
                                    '2' => 'Dipinjam',
                                    '3' => 'Sedang diperbaiki',
                                    '4' => 'Dikembalikan',
                                    '5' => 'Dimutasi',
                                    '6' => 'Selesai diperbaikai',
                                    '7' => 'Tidak dapat diperbaik',
                                ];
                            @endphp
                            <td>{{ $status[$lap->trs_detail_status] }}</td>
                            <td>{{ $lap->mainTransaksi->trs_keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row-lg-12" style="align-content: center;">
            <form action="{{ route('laporanTransaksiExcel') }}" method="GET" id="v_excel2">
                {{ csrf_field() }}
                <input type="hidden" value="{{ request()->start }}" name="start">
                <input type="hidden" value="{{ request()->end }}" name="end">
                <input type="hidden" value="{{ request()->gedung }}" name="gedung">
                <input type="hidden" value="{{ request()->ruangan }}" name="ruangan">
                <input type="hidden" value="{{ request()->type }}" name="type">
                <input type="hidden" value="{{ request()->status }}" name="status">
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
