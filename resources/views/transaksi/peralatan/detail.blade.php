{{-- !-- Delete Warning Modal -->  --}}
<form action="" method="post">
    <div class="modal-body">
        @csrf
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Perangkat</label>
            </div>
            <div class="col-md-8">
            @php
                $detail= $details->trsDetail->first();
            @endphp
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $detail->trsHasStok2->data_name;}}" placeholder="" readonly>
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
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value=" {{ $detail->trsHasStok2->stokHasMerk->nama_data_merk}}" placeholder="" readonly>
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
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value=" {{ $detail->trsHasStok2->data_keterangan;}}" placeholder="" readonly>
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
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawai_name }}" placeholder="" readonly>
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
                                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawaiHasBagian->nama_bagian }}" placeholder="" readonly>
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
                                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $key_1+1}}. {{ $value->pegawaiHasSubBagian->sub_bagian_nama }}" placeholder="" readonly>
                                
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
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{$key_1+1}}. {{$detail->trsHasGedung->nama_data_gedung}}" placeholder="" readonly>
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
                        <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{$key_1+1}}. {{$detail->trsHasRuangan->nama_data_ruangan}}" placeholder="" readonly>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    
</form>