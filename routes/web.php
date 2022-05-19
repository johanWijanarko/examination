<?php

use App\Helpers\SiteHelpers;
use App\Http\Controllers\BackupDb;
use App\Http\Controllers\Stokdata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Pelatihan;
use App\Http\Controllers\Pertanyaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanGrafik;
use App\Http\Controllers\LaporanMutasi;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AplikasiLaporan;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\FungsiController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\KotamaController;
use App\Http\Controllers\LaporanPerangkat;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\RekapitulasiData;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\LaporanAlatKantor;
use App\Http\Controllers\LaporanInventaris;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\DataMerkController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserExamController;
use App\Http\Controllers\LaporanAllNominatif;
use App\Http\Controllers\LaporanPengembalian;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\SubBagianController;
use App\Http\Controllers\TransaksiAlatKantor;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\DataAplikasiController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\TipeKategoryController;
use App\Http\Controllers\TransaksiInvController;
use App\Http\Controllers\DataPerangkatController;
use App\Http\Controllers\DataAlatKantorController;
use App\Http\Controllers\TransaksiAplikasiController;
use App\Http\Controllers\TransaksiPerangkatController;




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
// clear cache all
Route::get('/clear_session', function () {
    DB::table('users')->update(['session_id' => null]);
    echo '<script>alert("session clear Success")</script>';
});

Route::get('/cc', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('cache:clear');
    }else{
        Artisan::call('cache:clear');
    }

    echo '<script>alert("cache clear Success")</script>';
});

Route::get('/ccc', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('config:cache');
    }else{
        Artisan::call('config:cache');
    }

    echo '<script>alert("config cache Success")</script>';
});
Route::get('/vc', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('view:clear');
    }else{
        Artisan::call('view:clear');
    }

    echo '<script>alert("view clear Success")</script>';
});
Route::get('/cr', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('route:cache');
    }else{
        Artisan::call('route:cache');
    }

    echo '<script>alert("route clear Success")</script>';
});
Route::get('/coc', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('config:clear');
    }else{
        Artisan::call('config:clear');
    }
    echo '<script>alert("config clear Success")</script>';
});
Route::get('/storage123', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('storage:link');
    }else{
        Artisan::call('storage:link');
    }
    echo '<script>alert("linked")</script>';
});

Route::get('/dau', function () {
    if(Auth::user()){
        Auth::user()->session_id = '';
        Auth::user()->save();
        Artisan::call('dump-autoload');
    }else{
        Artisan::call('dump-autoload');
    }
    echo '<script>alert("dump-autoload Success")</script>';
});


Route::get('/', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard/', [Dashboard::class, 'index'])->name('dashboard');
    Route::post('dashboard/', [Dashboard::class, 'index'])->name('dashboard');
    Route::post('dashboard/detail_penugasan', [Dashboard::class, 'detail_penugasan'])->name('detail_penugasan');

    Route::resource('user/daftar_user', UserController::class)->names('users');
    Route::get('user/delete_user/{id}', [UserController::class, 'confrimDel'])->name('delete_user');
    Route::get('user/delete_users/{id}', [UserController::class, 'delete'])->name('delete_users');
    Route::get('user/backupdb', [BackupDb::class, 'index'])->name('index');
    Route::get('out_user/{id}', [UserController::class, 'out_user'])->name('out_user');
    Route::get('nonaktif/{id}', [UserController::class, 'nonaktif'])->name('nonaktif');
    Route::post('user/chek_user', [UserController::class, 'chek_user'])->name('chek_user');
    Route::resource('user/group_user', RoleController::class)->names('roles');
    Route::get('user/groupconfrimDel/{id}', [RoleController::class, 'confrimDel'])->name('deleteRole');
    Route::get('user/delete/{id}', [RoleController::class, 'delete'])->name('roledelete');
    // logs
    Route::get('user/log', [LogActivityController::class, 'index'])->name('logs');

    // menu
    Route::resource('user/menu', MenuController::class)->names('menu');
    Route::get('/menu/delete/{id}', [MenuController::class, 'delete'])->name('deleteMenu');

    Route::get('/menu/delete/{id}/{parent}', [MenuController::class, 'confrimdelete'])->name('deleteMenusub');
    Route::get('/menu/deletesub/{id}/{parent}', [MenuController::class, 'deleteSub'])->name('deleteMenu_');


    Route::get('user/menu/subMenu/{id}', [MenuController::class, 'submenu'])->name('submenu');
    Route::get('user/menu/sutambah/{id}', [MenuController::class, 'tbh_sub'])->name('tbh_sub');
    Route::post('user/menu/save_sub/{id}', [MenuController::class, 'save_sub'])->name('save_sub');
    Route::get('user/menu/edit_sub/{id}/{parent}', [MenuController::class, 'edit_sub'])->name('edit_sub');
    Route::post('user/menu/update_sub/{id}', [MenuController::class, 'update_sub'])->name('update_sub');



    // master pegawai

    Route::group(['prefix' => 'pegawai/daftarpegawai'], function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
        Route::get('addpegawai', [PegawaiController::class, 'tambah'])->name('addpegawai');
        Route::get('detailpegawai/{id}', [PegawaiController::class, 'detail'])->name('detailpegawai');
        Route::get('editlpegawai/{id}', [PegawaiController::class, 'edit'])->name('editlpegawai');
        Route::post('updatepegawai/{id}', [PegawaiController::class, 'update'])->name('updatepegawai');
        Route::post('save', [PegawaiController::class, 'save'])->name('save_pegawai');
        Route::get('confrim/{id}', [PegawaiController::class, 'confrim'])->name('confrimDelpgw');
        Route::get('deletePegawai/{id}', [PegawaiController::class, 'delete'])->name('deletePegawai');
        Route::post('cek_nip', [PegawaiController::class, 'cek_nip'])->name('cek_nip');
    });



    // pelatihan
    Route::post('pelatihan/save', [Pelatihan::class, 'save'])->name('savepelatihan');
    Route::get('pelatihan/detail', [pelatihan::class, 'detail'])->name('detail_pic');
    Route::post('pelatihan/update', [pelatihan::class, 'update'])->name('updatepelatihan');
    Route::get('pelatihan/confrim/{id}', [pelatihan::class, 'confrim'])->name('confrimPelatihan');
    Route::get('pelatihan/delete/{id}/{id_pgwai}', [pelatihan::class, 'delete'])->name('delpelatihan');



    Route::get('pegawai/getPegawai', [PegawaiController::class, 'getPegawai'])->name('getPegawai');
    // Route::get('m_inventaris/getDataBagian', [BagianController::class, 'getDataBagian'])->name('getDataBagian');

    Route::group(['prefix' => 'm_inventaris'], function () {
        // bagian
        Route::get('/bagian', [BagianController::class, 'index'])->name('bagian');
        Route::get('/getDataBagian', [BagianController::class, 'getDataBagian'])->name('getDataBagian');
        Route::post('/bagianSave', [BagianController::class, 'save'])->name('bagianSave');
        Route::get('/bagianEdit{id}', [BagianController::class, 'edit'])->name('bagianEdit');
        Route::post('/bagianUpdate', [BagianController::class, 'update'])->name('bagianUpdate');
        Route::get('/confrimdelbag{id}', [BagianController::class, 'confrimDelete'])->name('confrimdelbag');
        Route::get('/deletebagian/{id}', [BagianController::class, 'delete'])->name('deletebagian');


         // sub bagian
        Route::get('/sub_bagian', [SubBagianController::class, 'index'])->name('subbagian');
        Route::get('/getDataSubBagian', [SubBagianController::class, 'getDataSubBagian'])->name('getDataSubBagian');
        Route::post('/subbagianSave', [SubBagianController::class, 'save'])->name('subbagianSave');
        Route::get('/subbagianEdit{id}', [SubBagianController::class, 'edit'])->name('subbagianEdit');
        Route::get('/getBagianselected{id}', [SubBagianController::class, 'getBagianselected'])->name('getBagianselected');
        Route::post('/subBagianUpdate', [SubBagianController::class, 'update'])->name('subBagianUpdate');
        Route::get('/confrimdelsubbag{id}', [SubBagianController::class, 'confrimdelsubbag'])->name('confrimdelsubbag');
        Route::get('/deletebagiansub/{id}', [SubBagianController::class, 'delete'])->name('deletebagiansub');


        // DataMerkController\

        Route::get('/get_data_Merk', [DataMerkController::class, 'get_data_Merk'])->name('get_data_Merk');
        Route::get('/data_merk', [DataMerkController::class, 'index'])->name('data_merk');
        Route::post('/data_save_merk', [DataMerkController::class, 'save'])->name('data_save_merk');
        Route::get('/data_merk_edit{id}', [DataMerkController::class, 'edit'])->name('data_merk_edit');
        Route::post('/data_Merk_update', [DataMerkController::class, 'update'])->name('data_Merk_update');
        Route::get('/confrimdelMerk{id}', [DataMerkController::class, 'confrimDelete'])->name('confrimdelMerk');
        Route::get('/deleteMerk/{id}', [DataMerkController::class, 'delete'])->name('deleteMerk');


        // TipeKategoryController
        Route::get('/get_data_kategori', [TipeKategoryController::class, 'get_data_kategori'])->name('get_data_kategori');
        Route::get('/data_kategori', [TipeKategoryController::class, 'index'])->name('TipeKategory');
        Route::post('/data_save_kategory', [TipeKategoryController::class, 'save'])->name('data_save_kategory');
        Route::get('/data_kategory_edit{id}', [TipeKategoryController::class, 'edit'])->name('data_kategory_edit');
        Route::post('/data_kategory_update', [TipeKategoryController::class, 'update'])->name('data_kategory_update');
        Route::get('/confrimdelKategory{id}', [TipeKategoryController::class, 'confrimDelete'])->name('confrimdelKategory');
        Route::get('/deleteKategory{id}', [TipeKategoryController::class, 'delete'])->name('deleteKategory');

        // FungsiController
        Route::get('/get_data_fungsi', [FungsiController::class, 'get_data_fungsi'])->name('get_data_fungsi');
        Route::get('/data_fungsi', [FungsiController::class, 'index'])->name('fungsi');
        Route::post('/data_save_fungsi', [FungsiController::class, 'save'])->name('data_save_fungsi');
        Route::get('/data_fungsi_edit{id}', [FungsiController::class, 'edit'])->name('data_fungsi_edit');
        Route::post('/data_fungsi_update', [FungsiController::class, 'update'])->name('data_fungsi_update');
        Route::get('/confrimdelfungsi{id}', [FungsiController::class, 'confrimDelete'])->name('confrimdelfungsi');
        Route::get('/deleteFungsi{id}', [FungsiController::class, 'delete'])->name('deletefungsi');

        // KondisiController
        Route::get('/get_data_kondisi', [KondisiController::class, 'get_data_kondisi'])->name('get_data_kondisi');
        Route::get('/kondisi', [KondisiController::class, 'index'])->name('kondisi');
        Route::post('/data_save_kondisi', [KondisiController::class, 'save'])->name('data_save_kondisi');
        Route::get('/data_kondisi_edit{id}', [KondisiController::class, 'edit'])->name('data_kondisi_edit');
        Route::post('/data_kondisi_update', [KondisiController::class, 'update'])->name('data_kondisi_update');
        Route::get('/confrimdelkondisi{id}', [KondisiController::class, 'confrimDelete'])->name('confrimdelkondisi');
        Route::get('/deletekondisi{id}', [KondisiController::class, 'delete'])->name('deletekondisi');


        // Route::get('/kondisi', [KondisiController::class, 'index'])->name('kondisi');

        // LokasiController
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi');
        Route::get('/get_data_lokasi', [LokasiController::class, 'get_data_lokasi'])->name('get_data_lokasi');
        Route::post('/data_save_Lokasi', [LokasiController::class, 'save'])->name('data_save_Lokasi');
        Route::get('/data_Lokasi_edit{id}', [LokasiController::class, 'edit'])->name('data_Lokasi_edit');
        Route::post('/data_Lokasi_update', [LokasiController::class, 'update'])->name('data_Lokasi_update');
        Route::get('/confrimdellokasi{id}', [LokasiController::class, 'confrimDelete'])->name('confrimdellokasi');
        Route::get('/deleteLokasi{id}', [LokasiController::class, 'delete'])->name('deleteLokasi');
        Route::get('/get_kabupaten', [LokasiController::class, 'get_kabupaten'])->name('get_kabupaten');
        Route::get('/get_prov_edit{id}', [LokasiController::class, 'get_prov_edit'])->name('get_prov_edit');
        Route::get('/get_kab_edit{id}', [LokasiController::class, 'get_kab_edit'])->name('get_kab_edit');


        // pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
        Route::get('addpegawai', [PegawaiController::class, 'tambah'])->name('addpegawai');
        Route::get('detailpegawai/{id}', [PegawaiController::class, 'detail'])->name('detailpegawai');
        Route::get('editlpegawai/{id}', [PegawaiController::class, 'edit'])->name('editlpegawai');
        Route::post('updatepegawai/{id}', [PegawaiController::class, 'update'])->name('updatepegawai');
        Route::post('save', [PegawaiController::class, 'save'])->name('save_pegawai');
        Route::get('confrim/{id}', [PegawaiController::class, 'confrim'])->name('confrimDelpgw');
        Route::get('deletePegawai/{id}', [PegawaiController::class, 'delete'])->name('deletePegawai');
        Route::post('cek_nip', [PegawaiController::class, 'cek_nip'])->name('cek_nip');

        // gedung
        Route::get('/gedung', [GedungController::class, 'index'])->name('gedung');
        Route::get('/get_data_gedung', [GedungController::class, 'get_data_gedung'])->name('get_data_gedung');
        Route::post('/data_save_gedung', [GedungController::class, 'save'])->name('data_save_gedung');
        Route::get('/data_gedung_edit{id}', [GedungController::class, 'edit'])->name('data_gedung_edit');
        Route::post('/data_gedung_update', [GedungController::class, 'update'])->name('data_gedung_update');
        Route::get('/confrimdelgedung{id}', [GedungController::class, 'confrimDelete'])->name('confrimdelgedung');
        Route::get('/deletegedung{id}', [GedungController::class, 'delete'])->name('deletegedung');


        // SupplierController
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::get('/get_data_supplier', [SupplierController::class, 'get_data_supplier'])->name('get_data_supplier');
        Route::post('/data_save_supplier', [SupplierController::class, 'save'])->name('data_save_supplier');
        Route::get('/data_supplier_edit{id}', [SupplierController::class, 'edit'])->name('data_supplier_edit');
        Route::post('/data_supplier_update', [SupplierController::class, 'update'])->name('data_supplier_update');
        Route::get('/confrimdelsupplier{id}', [SupplierController::class, 'confrimDelete'])->name('confrimdelsupplier');
        Route::get('/deletesupplier{id}', [SupplierController::class, 'delete'])->name('deletesupplier');
        Route::get('/get_kabupaten_sup', [SupplierController::class, 'get_kabupaten_sup'])->name('get_kabupaten_sup');
        Route::get('/get_prov_sup{id}', [SupplierController::class, 'get_prov_sup'])->name('get_prov_sup');
        Route::get('/get_kab_sup{id}', [SupplierController::class, 'get_kab_sup'])->name('get_kab_sup');

        // RuanganController
        Route::get('/get_data_ruangan', [RuanganController::class, 'get_data_ruangan'])->name('get_data_ruangan');
        Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan');
        Route::post('/data_save_ruangan', [RuanganController::class, 'save'])->name('data_save_ruangan');
        Route::get('/data_ruangan_edit{id}', [RuanganController::class, 'edit'])->name('data_ruangan_edit');
        Route::post('/data_ruangan_update', [RuanganController::class, 'update'])->name('data_ruangan_update');
        Route::get('/confrimdelruangan{id}', [RuanganController::class, 'confrimDelete'])->name('confrimdelruangan');
        Route::get('/deleteruangan{id}', [RuanganController::class, 'delete'])->name('deleteruangan');
    });

    Route::group(['prefix' => 'm_data/data_stok'], function () {
        // perangkat
        Route::get('/', [Stokdata::class, 'index'])->name('stok');
        Route::get('/getDataStok', [Stokdata::class, 'getDataStok'])->name('getDataPerangkat');
        Route::get('/add', [Stokdata::class, 'tambah'])->name('add_stok');
        Route::post('/save', [Stokdata::class, 'save'])->name('save_stok');
        Route::get('/edit/{id}', [Stokdata::class, 'edit'])->name('edit_stok');
        Route::post('/update/{id}', [Stokdata::class, 'update'])->name('update_stok');
        Route::get('/confrimdelstok/{id}', [Stokdata::class, 'confrimDelete'])->name('confrimdelstok');
        Route::get('/delete/{id}', [Stokdata::class, 'delete'])->name('delete_stok');
    });



    Route::group(['prefix' => 'm_data/data_lainnya'], function () {
        // perangkat
        Route::get('/', [InventarisController::class, 'index'])->name('aplikasi');
        Route::get('/getDataInvent', [InventarisController::class, 'getDataInvent'])->name('getDataInvent');
        Route::get('/add', [InventarisController::class, 'tambah'])->name('add_Invent');
        Route::post('/save', [InventarisController::class, 'save'])->name('save_Invent');
        Route::get('/edit/{id}', [InventarisController::class, 'edit'])->name('edit_Invent');
        Route::post('/update/{id}', [InventarisController::class, 'update'])->name('update_Invent');
        Route::get('/confrimdelInvent/{id}', [InventarisController::class, 'confrimDelete'])->name('confrimdelInvent');
        Route::get('/delete/{id}', [InventarisController::class, 'delete'])->name('delete_Invent');
    });

    Route::group(['prefix' => 'transaksi_data/perangkat_trans'], function () {

        // trs perangkat
        Route::get('/', [TransaksiPerangkatController::class, 'index'])->name('trs_prangkat');
        Route::get('/add', [TransaksiPerangkatController::class, 'tambah'])->name('add_trs_prangkat');
        Route::get('/getTrsPerangkat', [TransaksiPerangkatController::class, 'getTrsPerangkat'])->name('getTrsPerangkat');
        Route::get('/getperangkat', [TransaksiPerangkatController::class, 'getperangkat'])->name('getperangkat');
        Route::post('/save', [TransaksiPerangkatController::class, 'save'])->name('save_trs');
        Route::get('/detail/{id}', [TransaksiPerangkatController::class, 'detail'])->name('detail_trs_prkt');
        Route::get('/edit/{id}', [TransaksiPerangkatController::class, 'edit'])->name('edit_trs');
        Route::post('/update/{id}', [TransaksiPerangkatController::class, 'update'])->name('update_trs');
        Route::get('/getSubBagian', [TransaksiPerangkatController::class, 'getSubBagian'])->name('getSubBagian');
        Route::get('/getPegawai', [TransaksiPerangkatController::class, 'getPegawai'])->name('getPegawai');
    });

    Route::group(['prefix' => 'transaksi_data/aplikasi_trans'], function () {

        // trs aplikasi
        Route::get('/', [TransaksiAplikasiController::class, 'index'])->name('trs_aplikasi');
        Route::get('/add', [TransaksiAplikasiController::class, 'tambah'])->name('add_trs_aplikasi');
        Route::get('/getTrsaplikasi', [TransaksiAplikasiController::class, 'getTrsaplikasi'])->name('getTrsaplikasi');
        Route::get('/gatAplikasi', [TransaksiAplikasiController::class, 'gatAplikasi'])->name('gatAplikasi');
        Route::post('/save', [TransaksiAplikasiController::class, 'save'])->name('save_trs_aplikasi');
        Route::get('/detail/{id}', [TransaksiAplikasiController::class, 'detail'])->name('detail_trs_aplikasi');
        Route::get('/edit/{id}', [TransaksiAplikasiController::class, 'edit'])->name('edit_trs_aplikasi');
        Route::post('/update/{id}', [TransaksiAplikasiController::class, 'update'])->name('update_trs_aplikasi');
        Route::get('/getSubBagian', [TransaksiAplikasiController::class, 'getSubBagian'])->name('getSubBagian');
        Route::get('/getPegawai', [TransaksiAplikasiController::class, 'getPegawai'])->name('getPegawai');
    });

// trs aplikasi
    Route::group(['prefix' => 'transaksi_data/p_kantor_trans'], function () {
        Route::get('/', [TransaksiAlatKantor::class, 'index'])->name('trs_aplikasi');
        Route::get('/add', [TransaksiAlatKantor::class, 'tambah'])->name('add_trs_alat_kantor');
        Route::get('/getTrsAtk', [TransaksiAlatKantor::class, 'getTrsAtk'])->name('getTrsAtk');
        Route::get('/gatAtk', [TransaksiAlatKantor::class, 'gatAtk'])->name('gatAtk');
        Route::post('/save', [TransaksiAlatKantor::class, 'save'])->name('save_trs_atk');
        Route::get('/detail/{id}', [TransaksiAlatKantor::class, 'detail'])->name('detail_trs_atk');
        Route::get('/edit/{id}', [TransaksiAlatKantor::class, 'edit'])->name('edit_trs_atk');
        Route::post('/update/{id}', [TransaksiAlatKantor::class, 'update'])->name('update_trs_atk');
        Route::get('/getSubBagian', [TransaksiAlatKantor::class, 'getSubBagian'])->name('getSubBagian');
        Route::get('/getPegawai', [TransaksiAplikasiController::class, 'getPegawai'])->name('getPegawai');
    });


    // trs aplikasi
    Route::group(['prefix' => 'transaksi_data/invtentaris_trans'], function () {
        Route::get('/', [TransaksiInvController::class, 'index'])->name('trsInv');
        Route::get('/add', [TransaksiInvController::class, 'tambah'])->name('add_trsInv');
        Route::get('/getTrsInv', [TransaksiInvController::class, 'getTrsInv'])->name('getTrsInv');
        Route::get('/gatInv', [TransaksiInvController::class, 'gatInv'])->name('gatInv');
        Route::post('/save', [TransaksiInvController::class, 'save'])->name('save_trsInv');
        Route::get('/detail/{id}', [TransaksiInvController::class, 'detail'])->name('detail_trsInv');
        Route::get('/edit/{id}', [TransaksiInvController::class, 'edit'])->name('edit_trsInv');
        Route::post('/update/{id}', [TransaksiInvController::class, 'update'])->name('update_trsInv');
    });

    Route::group(['prefix' => 'transaksi_data/mutasi'], function () {
        Route::get('/', [MutasiController::class, 'index'])->name('mutasi');
        Route::get('/getDtaMutasi', [MutasiController::class, 'getDtaMutasi'])->name('getDtaMutasi');
        Route::get('/detailMutasi/{id_trs}', [MutasiController::class, 'detailMutasi'])->name('detailMutasi');
        Route::get('/add', [MutasiController::class, 'tambah'])->name('add_mutasi');
        Route::get('/getObejkMutasi', [MutasiController::class, 'getObejkMutasi'])->name('getObejkMutasi');
        Route::get('/getPegawiMutasi', [MutasiController::class, 'getPegawiMutasi'])->name('getPegawiMutasi');
        Route::get('/getRekapMutasi', [MutasiController::class, 'getRekapMutasi'])->name('getRekapMutasi');
        Route::post('/save', [MutasiController::class, 'save'])->name('saveMutasi');
        Route::get('/edit/{id}', [MutasiController::class, 'edit'])->name('editMutasi');
        Route::post('/update/{id}', [MutasiController::class, 'update'])->name('update_mutasi');

    });

    Route::group(['prefix' => 'transaksi_data/pengembalian'], function () {
        Route::get('/', [PengembalianController::class, 'index'])->name('mutasi');
        Route::get('/add', [PengembalianController::class, 'tambah'])->name('add_kembali');
        Route::post('/save', [PengembalianController::class, 'save'])->name('savekembali');
        Route::get('/getObejkKembali', [PengembalianController::class, 'getObejkKembali'])->name('getObejkKembali');
        Route::get('/getPegawiKembali', [PengembalianController::class, 'getPegawiKembali'])->name('getPegawiKembali');
        Route::get('/getRekapKembali', [PengembalianController::class, 'getRekapKembali'])->name('getRekapKembali');
        Route::get('/getDataPengembalian', [PengembalianController::class, 'getDataPengembalian'])->name('getDataPengembalian');
        Route::get('/detail/{id}', [PengembalianController::class, 'detail'])->name('detailkembali');
        Route::get('/edit/{id}/{detail}', [PengembalianController::class, 'edit'])->name('editKembali');
        Route::get('/confrimApprove/{id}', [PengembalianController::class, 'confrimApprove'])->name('confrimApprove');
        Route::get('/approve/{id}/{trs_detail_id}', [PengembalianController::class, 'approve'])->name('approveKembali');
        Route::post('/update/{id}', [PengembalianController::class, 'update'])->name('update_kembali');
        // Route::get('/confrimApprove2/{id}', [PengembalianController::class, 'confrimApprove2'])->name('confrimApprove2');
    });


    Route::group(['prefix' => 'transaksi_data/perbaikan'], function () {
        Route::get('/', [PerbaikanController::class, 'index'])->name('perbaikan');
        Route::get('/getDataPerbaikan', [PerbaikanController::class, 'getDataPerbaikan'])->name('getDataPerbaikan');
        Route::get('/tambah', [PerbaikanController::class, 'tambah'])->name('tambahPerbaikan');
        Route::get('/getObejkPerbaikan', [PerbaikanController::class, 'getObejkPerbaikan'])->name('getObejkPerbaikan');
        Route::get('/getPegawiPerbaikan', [PerbaikanController::class, 'getPegawiPerbaikan'])->name('getPegawiPerbaikan');
        Route::get('/getRekapPerbaikan', [PerbaikanController::class, 'getRekapPerbaikan'])->name('getRekapPerbaikan');
        Route::post('/save', [PerbaikanController::class, 'save'])->name('saveperbaikan');
        Route::get('/detail/{id}/{trs_id}', [PerbaikanController::class, 'detail'])->name('detailPerbaikan');
        Route::get('/edit/{id}/{trs_id}', [PerbaikanController::class, 'edit'])->name('editPerbaikan');
        Route::post('/update/{id}', [PerbaikanController::class, 'update'])->name('updatePerbaikan');

    });

    Route::group(['prefix' => 'transaksi_data/peminjaman'], function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/tambah', [PeminjamanController::class, 'tambah'])->name('tambahPeminjaman');
        Route::get('/getDataPinjaman', [PeminjamanController::class, 'getDataPinjaman'])->name('getDataPinjaman');
        Route::get('/getObejkPeminjam', [PeminjamanController::class, 'getObejkPeminjam'])->name('getObejkPeminjam');
        Route::get('/getPinjam', [PeminjamanController::class, 'getPinjam'])->name('getPinjam');
        Route::post('/save', [PeminjamanController::class, 'save'])->name('savePeminjam');
        Route::get('/getPegawai', [PeminjamanController::class, 'getPegawai'])->name('getPegawai');

        Route::get('/detail/{id}', [PeminjamanController::class, 'detailpinjaman'])->name('detailpinjam');
        Route::get('/edit/{id}', [PeminjamanController::class, 'edit'])->name('editpinjam');
        Route::post('/update/{id}', [PeminjamanController::class, 'update'])->name('updatepinjam');
        Route::get('/confrimApprove/{id}', [PeminjamanController::class, 'confrimApprove'])->name('aprovePinjamConfrim');
        Route::get('/confrimReject/{id}', [PeminjamanController::class, 'confrimReject'])->name('confrimReject');
        Route::post('/aprovePinjam', [PeminjamanController::class, 'approve'])->name('aprovePinjam');
        Route::post('/reject', [PeminjamanController::class, 'reject'])->name('rejectPinjam');
        Route::get('/ketReject/{id}', [PeminjamanController::class, 'ketReject'])->name('ketReject');
    });

    Route::group(['prefix' => 'laporan_nominatif/'], function () {
        Route::get('/lap_transaksi', [LaporanAllNominatif::class, 'laporanTransaksi'])->name('laporanTransaksi');
        Route::get('/lap_transaksi-excel', [LaporanAllNominatif::class, 'laporanTransaksiExcel'])->name('laporanTransaksiExcel');
        Route::get('/lap_mutasi', [LaporanAllNominatif::class, 'laporanMutasi'])->name('laporanMutasi');
        Route::get('/lap_mutasiExcel', [LaporanAllNominatif::class, 'laporanMutasiExcel'])->name('laporanMutasiExcel');
        Route::get('/lap_peminjaman', [LaporanAllNominatif::class, 'laporanPeminjaman'])->name('laporanPeminjaman');
        Route::get('/lap_peminjamanExcel', [LaporanAllNominatif::class, 'laporanPeminjamanExcel'])->name('laporanPeminjamanExcel');
        Route::get('/lap_pengembalian', [LaporanAllNominatif::class, 'laporanPengembalian'])->name('laporanPengembalian');
        Route::get('/lap_pengembalianExcel', [LaporanAllNominatif::class, 'laporanPengembalianExcel'])->name('laporanPengembalianExcel');
        Route::get('/lap_perbaikan', [LaporanAllNominatif::class, 'laporanPerbaikan'])->name('laporanPerbaikan');
    });

    Route::group(['prefix' => 'pertanyan/'], function () {
        Route::get('/quest', [Pertanyaan::class, 'index'])->name('quest');
        Route::get('/create', [Pertanyaan::class, 'create'])->name('quest.create');
        Route::post('/save', [Pertanyaan::class, 'save'])->name('quest.save');
        Route::get('/exam', [ExamController::class, 'index'])->name('exam');
    });
    Route::group(['prefix' => 'pertanyan/'], function () {
        Route::get('/quest', [Pertanyaan::class, 'index'])->name('quest');
        Route::get('/create', [Pertanyaan::class, 'create'])->name('quest.create');
        Route::post('/save', [Pertanyaan::class, 'save'])->name('quest.save');
        Route::get('/exam', [ExamController::class, 'index'])->name('exam');
        Route::post('/savejawban', [ExamController::class, 'saveJwaban'])->name('exam');
        Route::post('/savejawban', [ExamController::class, 'saveJwaban'])->name('exam');
    });

    // data baru project ujian 
    // master data 

    Route::group(['prefix' => 'master/'], function () {
        Route::get('/kotama', [KotamaController::class, 'index'])->name('kotama');
        Route::post('/savekotama', [KotamaController::class, 'save'])->name('savekotama');
        Route::get('/getDataKotama', [KotamaController::class, 'getDataKotama'])->name('savekotama');
        Route::get('/editkotama{id}', [KotamaController::class, 'edit'])->name('editkotama');
        Route::post('/updatekotama', [KotamaController::class, 'update'])->name('updatekotama');
        Route::get('/confrimdeletekotama/{id}', [KotamaController::class, 'confrimDelete'])->name('confrimdeletekotama');
        Route::get('/deletekotama/{id}', [KotamaController::class, 'delete'])->name('deletekotama');
    });
    // ubah password cek
    Route::get('ubah_password/{id}', [HomeController::class, 'ubah_password'])->name('ubah_password');
    Route::post('update_password/{id}', [HomeController::class, 'update_password'])->name('update_password');


    // Route::get('genreate_id', function () {
    //     // $inspeksiGet = Inspeksi::get();
    //     $inspeksiGet = DB::table('auditor')->get();
    //     //    foreach ($inspeksiGet as  $tipe) {
    //     //     $uuid = Str::uuid()->toString();
    //     //        DB::table('auditor')->where('auditor_id',$tipe->auditor_id)->update([
    //     //            'id_get' =>  $uuid
    //     //        ]);

    //     //    }

    // });
});
