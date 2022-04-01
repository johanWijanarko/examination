{{-- !-- Delete Warning Modal -->  --}}
<form action="" method="post">
    <div class="modal-body">
        @csrf
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Perangkat</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasStok->data_name}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Merk</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasStok->stokHasMerk->nama_data_merk}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Kondisi</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasStok->stokHasKondisi->nama_data_kondisi}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Keterangan</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasStok->data_keterangan}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Pegawai</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasPegawai->pegawai_name}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Bagian</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasPegawai->pegawaiHasBagian->nama_bagian}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Sub Bagian</label>
            </div>
            <div class="col-md-8">
               
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasPegawai->pegawaiHasSubBagian->sub_bagian_nama}}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Gedung</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasGedung->nama_data_gedung }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Ruangan</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $trsPerangkat->trsHasRuangan->nama_data_ruangan }}" placeholder="" readonly>
            </div>
        </div>
    </div>
    
</form>