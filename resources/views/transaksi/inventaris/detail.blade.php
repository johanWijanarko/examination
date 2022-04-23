{{-- !-- Delete Warning Modal -->  --}}
<form action="" method="post">
    <div class="modal-body">
        @csrf
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Inventaris</label>

            </div>
            <div class="col-md-8">
            @php
                $detail= $details->trsDetail->first();
            @endphp
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $details->trsHasStok->data_name;}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Merk</label>
            </div>
            <div class="col-md-8">
                @php
                    $detail= $details->trsDetail->first();
                @endphp
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value=" {{ $details->trsHasStok->stokHasMerk->nama_data_merk}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Kondisi</label>
            </div>
            <div class="col-md-8">
                {{-- @php
                    $detail= $details->trsDetail->first();
                @endphp --}}
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value=" {{ $details->trsHasStok->stokHasKondisi->nama_data_kondisi}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Keterangan</label>
            </div>
            <div class="col-md-8">
                @php
                $detail= $details->trsDetail->first();
            @endphp
                   <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value=" {{ $details->trsHasStok->data_keterangan;}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Pegawai</label>
            </div>
            <div class="col-md-8">
                @if ($details->trsDetail)
                    @foreach ($details->trsDetail as $key_1 => $detail)
                        @if ($detail->hasManyPegawai)
                            @foreach ($detail->hasManyPegawai as $key => $value)
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawai_name }}" placeholder="" readonly><br>
                            @endforeach
                        @endif

                    @endforeach
                @endif

            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Bagian</label>
            </div>
            <div class="col-md-8">
                @if ($details->trsDetail)
                    @foreach ($details->trsDetail as $key_1 => $detail)
                        @if ($detail->hasManyPegawai)
                            @foreach ($detail->hasManyPegawai as $key => $value)
                                @if ($value->pegawaiHasBagian)
                                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawaiHasBagian->nama_bagian }}" placeholder="" readonly><br>
                                @endif
                            @endforeach
                        @endif

                    @endforeach
                @endif

            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Sub Bagian</label>
            </div>
            <div class="col-md-8">

                @if ($details->trsDetail)
                @foreach ($details->trsDetail as $key_1 => $detail)
                    @if ($detail->hasManyPegawai)
                        @foreach ($detail->hasManyPegawai as $key => $value)
                            @if ($value->pegawaiHasSubBagian)
                                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawaiHasSubBagian->sub_bagian_nama }}" placeholder="" readonly><br>

                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Gedung</label>
            </div>
            <div class="col-md-8">
                @if ($details->trsDetail)
                    @foreach ($details->trsDetail as $key_1 => $detail)
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{$key_1+1}}. {{$detail->trsHasGedung->nama_data_gedung}}" placeholder="" readonly><br>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Ruangan</label>
            </div>
            <div class="col-md-8">
                @if ($details->trsDetail)
                    @foreach ($details->trsDetail as $key_1 => $detail)
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{$key_1+1}}. {{$detail->trsHasRuangan->nama_data_ruangan}}" placeholder="" readonly><br>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</form>
