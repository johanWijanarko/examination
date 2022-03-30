<?php

use App\Models\Inspeksi;

use App\Http\Controllers\Chat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ParamCivil;
use App\Http\Controllers\TrsTiangMe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApproveCivil;
use App\Http\Controllers\ParamJabatan;
use App\Http\Controllers\ParamCekPjuts;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ParamMecanical;
use App\Http\Controllers\PendirianTiang;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Parampengecoran;
use App\Http\Controllers\SusunanTeamCtrl;
use App\Http\Controllers\ParamGalianTanah;
use App\Http\Controllers\ParamInstalasiPE;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrsSipilMandorCor;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Controllers\AsemblingCivilCtrl;
use App\Http\Controllers\ParamPerakitanTiang;
use App\Http\Controllers\SipilFormInspecCtrl;
use App\Http\Controllers\Trs_pendirian_tiang;
use App\Http\Controllers\UnitkerjaController;






use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ParamFungsiBidangCtr;
use App\Http\Controllers\SipilTransController;
use App\Http\Controllers\TrsMeinstalasi_pjuts;
use App\Http\Controllers\TrsSipilMandorGalian;
use App\Http\Controllers\MasterProyekController;
use App\Http\Controllers\ParamPegawaiController;
use App\Http\Controllers\ParamProjectController;
use App\Http\Controllers\AsemblingCivilTransaksi;
use App\Http\Controllers\InspectionTrfController;
use App\Http\Controllers\MasterPegawaiController;
use App\Http\Controllers\SubkontraktorController;
use App\Http\Controllers\TrsMeinstalasi_elektrik;
use App\Http\Controllers\TrsSipilMandorbegesting;
use App\Http\Controllers\ParamPemasanganBegesting;
use App\Http\Controllers\TrsSipilMandorController;
use App\Http\Controllers\TrsAsemblingSipilController;
use App\Http\Controllers\ParamInspeksiPeralatanElektrikal;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


Route::get('/',[LoginController::class,'showLoginForm']);
Route::post('/',[LoginController::class,'login'])->name('login');

Route::group(['middleware' => ['auth']], function() {
    
    // Route::get('/dashboard', function () { Activity::all(); return view('admin.index');});
    Route::get('/dashboard',[Dashboard::class,'index'])->name('dashboard');
    Route::post('detailChart',[Dashboard::class,'detailChart'])->name('detailChart');
    Route::get('shortByproject',[Dashboard::class,'shortByproject'])->name('shortByproject');
    
    
    Route::resource('user/daftar_user', UserController::class)->names('users');
    Route::resource('user/group_user', RoleController::class)->names('roles');
    Route::resource('products', ProductController::class);
    
    Route::resource('pegawai/mandor', SubkontraktorController::class)->names('mandor');
    Route::resource('user/menu', MenuController::class)->names('menu');
   


    // master pegawai
    Route::get('pegawai/master_pegawai',[MasterPegawaiController::class,'index'])->name('pegawai');
    Route::get('parameter/getpegawai',[MasterPegawaiController::class, 'get_dataPegawai'])->name('get_dataPegawai');
    Route::get('pegawai/detail/{id}',[MasterPegawaiController::class, 'detailPegawai'])->name('detailPegawai');
    Route::get('pegawai/getedit/{id}',[MasterPegawaiController::class, 'editPegawai'])->name('getedit');
    Route::post('pegawai/update/{id}',[MasterPegawaiController::class,'updatePegawai'])->name('pegawai.update');
    Route::get('/pegawai/tambah',[MasterPegawaiController::class,'tambah_pegawai'])->name('pegawai.tambah');
    Route::post('pegawai/save',[MasterPegawaiController::class,'save_pegawai'])->name('pegawai.save_pegawai');
    Route::get('/pegawai/delete/{id}',[MasterPegawaiController::class,'deletePegawai'])->name('pegawai.delete');

     // master proyek
     Route::get('pegawai/proyek',[MasterProyekController::class,'index'])->name('proyek');
     Route::get('pegawai/get_proyek',[MasterProyekController::class,'get_dataProyek'])->name('get_proyek');
     Route::get('pegawai/tambah_proyek',[MasterProyekController::class,'tambah_proyek'])->name('tambah.proyek');
     Route::get('pegawai/edit_proyek/{id}',[MasterProyekController::class,'edit_proyek'])->name('edit_proyek');
     Route::post('pegawai/save_proyek',[MasterProyekController::class,'save_proyek'])->name('save_proyek');
     Route::post('pegawai/update_proyek/{id}',[MasterProyekController::class,'update_proyek'])->name('update_proyek');
     Route::get('pegawai/delete_proyek/{id}',[MasterProyekController::class,'delete_proyek'])->name('delete_proyek');

         // * pegawai 
    Route::get('parameter/pegawai',[ParamPegawaiController::class, 'index'])->name('param_pegawai');

    Route::get('parameter/fungsiBidang',[ParamFungsiBidangCtr::class, 'index'])->name('fungsiBidang');
    Route::get('parameter/get_fungsibidang',[ParamFungsiBidangCtr::class, 'get_fungsibidang'])->name('get_fungsibidang');

 

    // *project 
    Route::get('parameter/project',[ParamProjectController::class, 'index'])->name('param_project');


    // param unitkerja
    Route::get('parameter/unit_kerja',[UnitkerjaController::class, 'index'])->name('unit_kerja');
    Route::get('parameter/cari_unit_kerja',[UnitkerjaController::class, 'cari'])->name('cari');
    Route::get('parameter/tambah_unit_kerja',[UnitkerjaController::class, 'tambah'])->name('tambah');
    Route::post('parameter/save_unit_kerja',[UnitkerjaController::class, 'save'])->name('save');
    Route::get('parameter/delete_uk/{id}',[UnitkerjaController::class,'delete_uk'])->name('delete_uk');
    Route::get('parameter/edit_uk/{id}',[UnitkerjaController::class, 'edit'])->name('edit');
    
    // param jabatan
    
    Route::get('parameter/jabatan',[ParamJabatan::class,'index'])->name('jabatan');
    Route::get('parameter/tambah_jabatan',[ParamJabatan::class,'tambah'])->name('tambah_jabatan');
    Route::post('parameter/save_jabatan',[ParamJabatan::class,'save'])->name('save_jabatan');
    Route::get('parameter/delete_jabatan/{id}',[ParamJabatan::class,'delete_jabatan'])->name('delete_jabatan');
    Route::get('parameter/edit_jabatan/{id}',[ParamJabatan::class,'edit'])->name('edit_jabatan');
    Route::post('parameter/update_jabatan/{id}',[ParamJabatan::class,'update'])->name('update_jabatan');
    Route::get('parameter/cari_jabatan',[ParamJabatan::class,'cari'])->name('cari_jabatan');
    
    
    // parameter civil 
    Route::get('parameter/sipil',[ParamCivil::class, 'index'])->name('param_sipil');

    // asmebling
    Route::get('parameter/asembling_sipil',[AsemblingCivilCtrl::class, 'index'])->name('asembling_sipil');
    Route::get('parameter/asembling_sipil/tambah',[AsemblingCivilCtrl::class, 'tambah'])->name('tambh_asemblCvl');
    Route::post('parameter/asembling_sipil/save',[AsemblingCivilCtrl::class, 'save'])->name('save_asemblCvl');
    Route::get('parameter/asembling_sipil/edit/{id}',[AsemblingCivilCtrl::class, 'edit'])->name('edit_asemblCvl');
    Route::post('parameter/asembling_sipil/update/{id}',[AsemblingCivilCtrl::class, 'update'])->name('update_asemblCvl');
    Route::get('parameter/asembling_sipil/delete/{id}}',[AsemblingCivilCtrl::class, 'delete'])->name('delete_asemblCvl');

    // galian tanah
    Route::get('parameter/galianTanah',[ParamGalianTanah::class, 'index'])->name('galianTanah');
    Route::get('parameter/galianTanah/tambah',[ParamGalianTanah::class, 'tambah'])->name('tambah_galian');
    Route::post('parameter/galianTanah/save',[ParamGalianTanah::class, 'save'])->name('save_galian');
    Route::get('parameter/galianTanah/edit/{id}',[ParamGalianTanah::class, 'edit'])->name('edit_galian');
    Route::post('parameter/galianTanah/update/{id}',[ParamGalianTanah::class, 'update'])->name('update_galian');
    Route::get('parameter/galianTanah/delete/{id}',[ParamGalianTanah::class, 'delete'])->name('delete_galian');
    Route::get('parameter/galianTanah/detail/{id}',[ParamGalianTanah::class, 'detail'])->name('detail_galian');

    // galian begesting
    Route::get('parameter/begesting',[ParamPemasanganBegesting::class, 'index'])->name('begesting');
    Route::get('parameter/begesting/tambah',[ParamPemasanganBegesting::class, 'tambah'])->name('tambah_begesting');
    Route::post('parameter/begesting/save',[ParamPemasanganBegesting::class, 'save'])->name('save_begesting');
    Route::get('parameter/begesting/edit/{id}',[ParamPemasanganBegesting::class, 'edit'])->name('edit_begesting');
    Route::post('parameter/begesting/update/{id}',[ParamPemasanganBegesting::class, 'update'])->name('update_begesting');
    Route::get('parameter/begesting/delete/{id}',[ParamPemasanganBegesting::class, 'delete'])->name('delete_begesting');
    Route::get('parameter/begesting/detail/{id}',[ParamPemasanganBegesting::class, 'detail'])->name('detail_begesting');
    

    // galian pengecoran
    Route::get('parameter/pengecoran',[Parampengecoran::class, 'index'])->name('pengecoran');
    Route::get('parameter/pengecoran/tambah',[Parampengecoran::class, 'tambah'])->name('tambah_pengecoran');
    Route::post('parameter/pengecoran/save',[Parampengecoran::class, 'save'])->name('save_pengecoran');
    Route::get('parameter/pengecoran/edit/{id}',[Parampengecoran::class, 'edit'])->name('edit_pengecoran');
    Route::post('parameter/pengecoran/update/{id}',[Parampengecoran::class, 'update'])->name('update_pengecoran');
    Route::get('parameter/pengecoran/delete/{id}',[Parampengecoran::class, 'delete'])->name('delete_pengecoran');
    Route::get('parameter/pengecoran/detail/{id}',[Parampengecoran::class, 'detail'])->name('detail_pengecoran');

     // parameter mecanical 
     Route::get('parameter/Me',[ParamMecanical::class, 'index'])->name('param_mecanical');


    // param perakitan tiang
    Route::get('parameter/Me/perakitan_tiang',[ParamPerakitanTiang::class, 'index'])->name('perakitan_tiang');
    Route::get('parameter/Me/perakitan_tiang/tambah',[ParamPerakitanTiang::class, 'tambah'])->name('perakitan_tiang_tambah');
    Route::post('parameter/Me/perakitan_tiang/save',[ParamPerakitanTiang::class, 'save'])->name('save_tiang');
    Route::get('parameter/Me/perakitan_tiang/edit/{id}',[ParamPerakitanTiang::class, 'edit'])->name('edit_tiang');
    Route::post('parameter/Me/perakitan_tiang/update/{id}',[ParamPerakitanTiang::class, 'update'])->name('update_tiang');
    Route::get('parameter/Me/perakitan_tiang/delete/{id}',[ParamPerakitanTiang::class, 'delete'])->name('delete_tiang');


    // param instalasi_pe
    Route::get('parameter/Me/instalasipe',[ParamInstalasiPE::class, 'index'])->name('instalasipe');
    Route::get('parameter/Me/instalasipe/tambah',[ParamInstalasiPE::class, 'tambah'])->name('instalasipe_tambah');
    Route::post('parameter/Me/instalasipe/save',[ParamInstalasiPE::class, 'save'])->name('save_instalasipe');
    Route::get('parameter/Me/instalasipe/edit/{id}',[ParamInstalasiPE::class, 'edit'])->name('edit_instalasipe');
    Route::post('parameter/Me/instalasipe/update/{id}',[ParamInstalasiPE::class, 'update'])->name('update_instalasipe');
    Route::get('parameter/Me/instalasipe/delete/{id}',[ParamInstalasiPE::class, 'delete'])->name('delete_instalasipe');


     // param pjuts
     Route::get('parameter/Me/pjuts',[ParamCekPjuts::class, 'index'])->name('pjuts');
     Route::get('parameter/Me/pjuts/tambah',[ParamCekPjuts::class, 'tambah'])->name('pjuts_tambah');
     Route::post('parameter/Me/pjuts/save',[ParamCekPjuts::class, 'save'])->name('save_pjuts');
     Route::get('parameter/Me/pjuts/edit/{id}',[ParamCekPjuts::class, 'edit'])->name('edit_pjuts');
     Route::post('parameter/Me/pjuts/update/{id}',[ParamCekPjuts::class, 'update'])->name('update_pjuts');
     Route::get('parameter/Me/pjuts/delete/{id}',[ParamCekPjuts::class, 'delete'])->name('delete_pjuts');

     // param pjuts
     Route::get('parameter/pendirian_tiang',[PendirianTiang::class, 'index'])->name('pendirianTiang');
     Route::get('parameter/Me/pendirian_tiang/tambah',[PendirianTiang::class, 'tambah'])->name('pendirian_tiang_tambah');
     Route::post('parameter/Me/pendirian_tiang/save',[PendirianTiang::class, 'save'])->name('save_pendirian_tiang');
     Route::get('parameter/Me/pendirian_tiang/edit/{id}',[PendirianTiang::class, 'edit'])->name('edit_pendirian_tiang');
     Route::post('parameter/Me/pendirian_tiang/update/{id}',[PendirianTiang::class, 'update'])->name('update_pendirian_tiang');
     Route::get('parameter/Me/pendirian_tiang/delete/{id}',[PendirianTiang::class, 'delete'])->name('delete_pendirian_tiang');

      // param inspeksiElektrikal
      Route::get('parameter/Me/inspeksiElektrikal',[ParamInspeksiPeralatanElektrikal::class, 'index'])->name('inspeksiElektrikal');

      Route::get('parameter/Me/inspeksiElektrikal/tambah',[ParamInspeksiPeralatanElektrikal::class, 'tambah'])->name('inspeksiElektrikal_tambah');

      Route::post('parameter/Me/inspeksiElektrikal/save',[ParamInspeksiPeralatanElektrikal::class, 'save'])->name('save_inspeksiElektrikal');

      Route::get('parameter/Me/inspeksiElektrikal/edit/{id}',[ParamInspeksiPeralatanElektrikal::class, 'edit'])->name('edit_inspeksiElektrikal');

      Route::post('parameter/Me/inspeksiElektrikal/update/{id}',[ParamInspeksiPeralatanElektrikal::class, 'update'])->name('update_inspeksiElektrikal');
      
      Route::get('parameter/Me/pjinspeksiElektrikaluts/delete/{id}',[ParamInspeksiPeralatanElektrikal::class, 'delete'])->name('delete_inspeksiElektrikal');
    
    // trf inspection 
    Route::get('inspection/trf',[InspectionTrfController::class, 'index'])->name('trfinspec');
    Route::get('inspection/main_menu',[AsemblingCivilTransaksi::class, 'index'])->name('index_transaksi');
    Route::get('inspection/mecanical',[AsemblingCivilTransaksi::class, 'mecanical'])->name('index_mecanical');
    Route::get('inspection/cari_data',[InspectionTrfController::class, 'cari'])->name('cari_transaksi');
    Route::get('inspection/review',[InspectionTrfController::class, 'review_project'])->name('review_project');
    Route::post('inspection/getproject',[InspectionTrfController::class, 'getproject'])->name('getproject');
    Route::post('inspection/refnumbers',[InspectionTrfController::class, 'refnumbers'])->name('refnumbers');
    Route::post('inspection/manajerSearch',[InspectionTrfController::class, 'manajerProject'])->name('manajerProject');
    Route::post('inspection/auditorSearch',[InspectionTrfController::class, 'get_vendors'])->name('get_vendors');
    
    Route::get('inspection/get_filter',[InspectionTrfController::class, 'index'])->name('get_filter');


    // sipil transaksi
    Route::get('inspection/sipiltrs',[SipilTransController::class, 'index'])->name('sipiltrs');

    Route::get('inspection/sipiltrs_tbh',[SipilTransController::class, 'tambah'])->name('sipiltrs_tbh');
    Route::get('inspection/sipiltrs_get_kota',[SipilTransController::class, 'kota'])->name('sipiltrs_get_kota');
    Route::get('inspection/sipiltrs_get_kecamatan',[SipilTransController::class, 'kecamatan'])->name('sipiltrs_get_kecamatan');
    Route::get('inspection/sipiltrs_get_kelurahan',[SipilTransController::class, 'kelurahan'])->name('inspection/sipiltrs_get_kelurahan');
    
    Route::post('inspection/sipiltrs_save',[SipilTransController::class, 'save'])->name('sipiltrs_save');
    Route::get('inspection/sipiltrs_edit/{id}',[SipilTransController::class, 'edit'])->name('sipiltrs_edit');
    Route::post('inspection/sipiltrs_update/{id}',[SipilTransController::class, 'update'])->name('sipiltrs_update');
    Route::get('inspection/sipiltrs_detail/{id}',[SipilTransController::class, 'detail'])->name('sipiltrs_detail');
    Route::get('inspection/sipiltrs_delete/{id}',[SipilTransController::class, 'delete'])->name('sipiltrs_delete');
    Route::post('inspection/cek_refnumber',[SipilTransController::class, 'cekRef'])->name('cek_refnumber');
    // Route::post('inspection/cek_refnumber',[SipilTransController::class, 'cekRef'])->name('cek_refnumber');

    //asembling civil transaksi
    Route::get('asembling/civiltrs',[AsemblingCivilTransaksi::class, 'asemblingTrs'])->name('trsAsemblSipil');
    Route::post('asembling/save_trs',[AsemblingCivilTransaksi::class, 'transaksi_save'])->name('save_trs');  
    
    // Route::post('asembling/save_krimdkumen',[AsemblingCivilTransaksi::class, 'save_krimdkumen'])->name('save_krimdkumen');
    // Route::post('asembling/update_dokumen',[AsemblingCivilTransaksi::class, 'update_dokumen'])->name('update_krimdkumen');    
    
    // asembling transaksi
    Route::get('inspection/save_trs_asembling_index',[TrsAsemblingSipilController::class, 'index'])->name('index_asembling_civil');
    Route::post('inspection/save_trs_asembling',[TrsAsemblingSipilController::class, 'transaksi_save'])->name('save_trs_asembling');
    Route::post('asembling/save_krimdkumen',[TrsAsemblingSipilController::class, 'kirim_dokumen'])->name('kirim_dokumen'); 
    Route::post('asembling/approve_dokumen',[TrsAsemblingSipilController::class, 'approve_dokumen'])->name('approve_dokumen'); 
    Route::post('asembling/reject_dokumen',[TrsAsemblingSipilController::class, 'reject_dokumen'])->name('reject_dokumen'); 
    Route::post('asembling/update_dokumen',[TrsAsemblingSipilController::class, 'update_dokumen'])->name('update_dokumen');
    Route::post('inspection/inspeksi_sipil_selesai',[TrsAsemblingSipilController::class, 'trs_selesai'])->name('inspeksi_sipil_selesai');


    // transaksi mandor sipil asembling
    Route::get('inspection/trs_mandor',[TrsSipilMandorController::class, 'index'])->name('trs_mandor');
    Route::get('inspection/trs_mandorAsembling',[TrsSipilMandorController::class, 'trsasemblingMandor'])->name('trs_mandorAsembling');


    // transaksi mandor sipil  galian tanah
    Route::get('inspection/trs_mandor_galian',[TrsSipilMandorGalian::class, 'index'])->name('trs_mandor_galian');
    Route::get('inspection/trs_mandorGalian',[TrsSipilMandorGalian::class, 'trsGalianMandor'])->name('trsGalianMandor');
    Route::post('inspection/save_trs_galian',[TrsSipilMandorGalian::class, 'transaksi_save'])->name('save_trs_galian');
    Route::post('inspection/kirimdokumen_trs_galian',[TrsSipilMandorGalian::class, 'kirim_dokumen'])->name('kirim_dokumen');

    Route::get('inspection/inspeksi_galian',[TrsSipilMandorGalian::class, 'index'])->name('galiantrs');
    Route::post('inspection/approve_galian',[TrsSipilMandorGalian::class, 'approve_dokumen'])->name('approve_dokumen');
    Route::post('inspection/update_dokumen',[TrsSipilMandorGalian::class, 'update_dokumen'])->name('update_dokumen_galian');
     Route::post('inspection/inspeksi_galian_selesai',[TrsSipilMandorGalian::class, 'trs_selesai'])->name('trs_galian_selesai');

    


     // transaksi mandor Begesting sipil
     Route::get('inspection/trs_mandor_begesting',[TrsSipilMandorbegesting::class, 'index'])->name('trsbegesting');
     Route::post('inspection/approve_beges',[TrsSipilMandorbegesting::class, 'approve_dokumen'])->name('approve_dokumen');

     Route::get('inspection/trsBegestMandor',[TrsSipilMandorbegesting::class, 'trsBegestMandor'])->name('trsBegestMandor');
     Route::post('inspection/save_trs_beges',[TrsSipilMandorbegesting::class, 'transaksi_save'])->name('save_trs_beges');
     Route::post('inspection/kirimdokumen_trs_beges',[TrsSipilMandorbegesting::class, 'kirim_dokumen'])->name('kirimdokumen_trs_beges');
    Route::post('inspection/inspeksi_beges_selesai',[TrsSipilMandorbegesting::class, 'trs_selesai'])->name('trs_beges_selesai');
     Route::post('inspection/update_dokumen_beges',[TrsSipilMandorbegesting::class, 'update_dokumen'])->name('update_dokumen_beges');

    // transaksi mandor cor sipil
    Route::get('inspection/inspeksi_cor',[TrsSipilMandorCor::class, 'index'])->name('trs_mandor_cor');
    Route::post('inspection/approve_cor',[TrsSipilMandorCor::class, 'approve_dokumen'])->name('approve_dokumen_cor');

    Route::get('inspection/trsCorMandor',[TrsSipilMandorCor::class, 'trsCorMandor'])->name('trsCorMandor');
    Route::post('inspection/save_trs_cor',[TrsSipilMandorCor::class, 'transaksi_save'])->name('save_trs_cor');
    Route::post('inspection/kirimdokumen_trs_cor',[TrsSipilMandorCor::class, 'kirim_dokumen'])->name('kirimdokumen_trs_cor');
    Route::post('inspection/update_dokumen_cor',[TrsSipilMandorCor::class, 'update_dokumen'])->name('update_dokumen_cor');
    Route::post('inspection/inspeksi_cor_selesai',[TrsSipilMandorCor::class, 'trs_selesai'])->name('trs_cor_selesai');


    // menu All MEcanical
    Route::get('inspection/mecanical_elektrik_menu',[TrsMeinstalasi_elektrik::class, 'menu_me'])->name('trs_mecanical_mandor');
    
    // transaksi Mecanical inspektor
    Route::get('inspection/mecanical_elektrik',[TrsMeinstalasi_elektrik::class, 'index'])->name('peralatan_elektrikal_inspeksi'); 
    Route::post('inspection/approve_perlatanElektrikal',[TrsMeinstalasi_elektrik::class, 'approve_dokumen'])->name('approve_dokumen');
    Route::post('inspection/inspeksi_elektrikal_selesai',[TrsMeinstalasi_elektrik::class, 'trs_selesai'])->name('inspeksi_elektrikal_selesai');
    

    // // transaksi Mecanical mndor
    Route::get('inspection/perlatanElektrikal',[TrsMeinstalasi_elektrik::class, 'perlatanElektrikal'])->name('perlatanElektrikal');
    Route::post('inspection/save_trs_perlatanElektrikal',[TrsMeinstalasi_elektrik::class, 'transaksi_save'])->name('save_trs_perlatanElektrikal');
    Route::post('inspection/kirimdokumen_trs_perlatanElektrikal',[TrsMeinstalasi_elektrik::class, 'kirim_dokumen'])->name('kirimdokumen_trs_perlatanElektrikal');
    

    // transaksi Mecanical Pengecekan dan pengujian PJU TS
    Route::get('inspection/mecanical_pjuts',[TrsMeinstalasi_pjuts::class, 'index'])->name('mechanical_pjuts'); 
    Route::post('inspection/mecanical_pjuts_approve',[TrsMeinstalasi_pjuts::class, 'approve_dokumen'])->name('approve_dokumen');

    // // transaksi Mecanical Pengecekan dan pengujian PJU TS
    Route::get('inspection/mecanical_pjuts_mandor',[TrsMeinstalasi_pjuts::class, 'mecanical_pjuts'])->name('mecanical_pjuts_mandor');
    Route::post('inspection/save_trs_mecanical_pjuts',[TrsMeinstalasi_pjuts::class, 'transaksi_save'])->name('save_trs_mecanical_pjuts');
    Route::post('inspection/kirimdokumen_mecanical_pjuts',[TrsMeinstalasi_pjuts::class, 'kirim_dokumen'])->name('kirimdokumen_mecanical_pjuts'); 
    Route::post('inspection/inspeksi_pjuts_selesai',[TrsMeinstalasi_pjuts::class, 'trs_selesai'])->name('inspeksi_pjuts_selesai'); 

    //  Inspeksi installasi Tiang Mechanical
    Route::get('inspection/mecanical_tiang',[TrsTiangMe::class, 'index'])->name('mecanical_tiang'); 
    Route::post('inspection/mecanical_tiang_approve',[TrsTiangMe::class, 'approve_dokumen'])->name('approve_dokumen');

    // // transaksi Mecanical Pengecekan dan pengujian PJU TS
    Route::get('inspection/mecanical_tiang_mandor',[TrsTiangMe::class, 'mecanical_tiang'])->name('mecanical_tiang_mandor');
    Route::post('inspection/save_trs_mecanical_tiang',[TrsTiangMe::class, 'transaksi_save'])->name('save_trs_mecanical_tiang');
    Route::post('inspection/kirimdokumen_mecanical_tiang',[TrsTiangMe::class, 'kirim_dokumen'])->name('kirimdokumen_mecanical_tiang'); 
    Route::post('inspection/inspeksi_tiang_selesai',[TrsTiangMe::class, 'trs_selesai'])->name('inspeksi_tiang_selesai'); 


    // Trs pendirian tiang
    Route::get('inspection/trs_pendirian_tiang',[Trs_pendirian_tiang::class, 'index'])->name('trs_pendirian_tiang'); 
    Route::post('inspection/trs_pendirian_tiang_approve',[Trs_pendirian_tiang::class, 'approve_dokumen'])->name('approve_dokumen');
    Route::post('inspection/inspeksi_pendiriantiang_selesai',[Trs_pendirian_tiang::class, 'trs_selesai'])->name('inspeksi_pendiriantiang_selesai');
   
    Route::get('inspection/pendirianTiangTrs',[Trs_pendirian_tiang::class, 'trsPendirianTiangMandor'])->name('trsPendirianTiangMandor');
    Route::post('inspection/save_trs_pendirianTiangTrs',[Trs_pendirian_tiang::class, 'transaksi_save'])->name('save_trs_Trs_pendirian_tiang');
    Route::post('inspection/kirimdokumen_pendirianTiangTrs',[Trs_pendirian_tiang::class, 'kirim_dokumen'])->name('kirimdokumen_Trs_pendirian_tiang'); 
    // // approve 1
    // Route::get('approve/approve1',[ApproveCivil::class, 'index'])->name('approve1');
    // Route::post('approve/approve_ok',[ApproveCivil::class, 'approve_ok'])->name('approve_ok');
    // Route::post('approve/reject',[ApproveCivil::class, 'reject'])->name('reject');

    //Chat
    Route::get('help/chat',[Chat::class, 'index'])->name('chat_admin');
    Route::get('help/create_chat',[Chat::class, 'create'])->name('create_chat');
    Route::post('help/save_chat',[Chat::class, 'save'])->name('save_chat');
    Route::get('help/balas_chat/{id}',[Chat::class, 'balas_chat'])->name('balas_chat');
    Route::post('help/terima_chat/{id}',[Chat::class, 'terima_chat'])->name('kirim_chat');
    Route::post('help/selesai_chat',[Chat::class, 'selesai_chat'])->name('selesai_chat');
    

    //susunan team 
    Route::get('inspection/trf/team/susunan',[SusunanTeamCtrl::class, 'index'])->name('susunanTeam');
    Route::get('inspection/trf/team/susunanTambah',[SusunanTeamCtrl::class, 'tambah'])->name('susunanTambah');
    Route::post('inspection/trf/team/susunanSave',[SusunanTeamCtrl::class, 'save'])->name('susunanSave');
    Route::get('inspection/trf/team/susunanEdit/{id}',[SusunanTeamCtrl::class, 'edit'])->name('susunanEdit');
    Route::post('inspection/trf/team/susunanUpdate/{id}',[SusunanTeamCtrl::class, 'update'])->name('susunanUpdate');
    Route::get('inspection/trf/team/susunanDelete/{id}',[SusunanTeamCtrl::class, 'delete'])->name('susunanDelete');

    // notifikasi reject dan upload data
    Route::post('data/notif',[NotifikasiController::class, 'notifikasi_data'])->name('notify');

    // ubah password
    Route::get('ubah_password/{id}', [HomeController::class, 'ubah_password'])->name('ubah_password');
    Route::post('update_password/{id}',[HomeController::class, 'update_password'])->name('update_password');

//     Route::get('genreate_tipeInspeksi',function(){
//     //    trf1
//     // $inspeksiGet = Inspeksi::get();
//     $tipeInspeksi = [
//         'Asembling',
//         'Galian',
//         'Begesting',
//         'Pengecoran',
//         'Tiang',
//         'Elektrikal',
//         'Pjuts',
//         'Pendirian_tiang'
//     ];
    
//     $counttipeInspeksi=  DB::table('tb_tipe_inspeksi')->where('id_inspeksi','trf1')->count();
//    if(!$counttipeInspeksi){

//        foreach ($tipeInspeksi as  $tipe) {
//            DB::table('tb_tipe_inspeksi')->insert([
//                'id_inspeksi' => 'trf1',
//                'tipe_inspeksi' => $tipe

//            ]);
   
//        }
//    }
//     });
    
});