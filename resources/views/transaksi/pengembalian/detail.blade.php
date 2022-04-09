{{-- !-- Delete Warning Modal -->  --}}
<form action="" method="post">
    <div class="modal-body">
        @csrf
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Jenis Pengembalian</label>
            </div>
            <div class="col-md-8">
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasType->nama_data_type }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Objek Pengembalian</label>
            </div>
            <div class="col-md-8">
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasObjek->data_name }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Nama Pegawai</label>
            </div>
            <div class="col-md-8">
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasPegawai->pegawai_name }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Bagian</label>
            </div>
            <div class="col-md-8">
                @if ($datakembali->kembaliHasPegawai->pegawaiHasBagia)
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasBagian->nama_bagian  ?  : '' }}" placeholder="" readonly>
                @else
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="" placeholder="" readonly>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">SubBagian</label>
            </div>
            <div class="col-md-8">
                @if ($datakembali->kembaliHasPegawai->pegawaiHasSubBagian)
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama }}" placeholder="" readonly>
                @else
                    <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="" placeholder="" readonly>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Kondisi Sebelum</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasKondisiSblm->nama_data_kondisi }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Kondisi Sesudah</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->kembaliHasKondisiSkrg->nama_data_kondisi }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Keterangan</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->pengembalian_keterangan }}" placeholder="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label class="col-form-label">Jumlah Pengembalian</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_trs_prkt" id="id_trs_prkt" class="form-control" value="{{ $datakembali->pengembalian_jumlah }}" placeholder="" readonly>
            </div>
        </div>
    </div>

</form>
