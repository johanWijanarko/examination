<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanModels extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    protected $fillable = ['peminjaman_id', 'peminjaman_kode', 'peminjamanType', 'peminjaman_obejk_id','peminjaman_pegawai_id', 'peminjaman_tanggal', 'peminjaman_gedung_id','peminjaman_ruangan_id','peminjaman_pic_id','peminjaman_kelompok_id','peminjaman_keterangan','peminjaman_jumlah','created_at', 'updated_at'];

    public function peminjamanHasObjek(){
        return $this->belongsTo(StokModels::class, 'peminjaman_obejk_id', 'data_stok_id');
    }
    public function peminjamanHasPegawai(){
        return $this->belongsTo(PegawaiModels::class, 'peminjaman_pegawai_id', 'pegawai_id');
    }
     public function peminjamanHasGedung()
    {
        return $this->belongsTo(GedungModels::class, 'peminjaman_gedung_id', 'data_gedung_id');
    }
    public function peminjamanHasRuangan()
    {
        return $this->belongsTo(RuanganModels::class, 'peminjaman_ruangan_id', 'data_ruangan_id');
    }

    public function peminjamanHasType()
    {
        return $this->belongsTo(TypeKtegoryModels::class, 'peminjamanType', 'data_type_id');
    }

    public function pinjamHasTrsDetail()
    {
        return $this->belongsTo(DetailTransaksi::class, 'peminjaman_id', 'trs_detail_pinjam_id');
    }
    
}
