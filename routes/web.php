<?php

use App\Helpers\SiteHelpers;
use App\Http\Controllers\BackupDb;
// cek
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Pelatihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanGrafik;
use App\Http\Controllers\LaporanMutasi;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AplikasiLaporan;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\FungsiController;
use App\Http\Controllers\GedungController;
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
        Route::get('/deletebagian{id}', [BagianController::class, 'delete'])->name('deletebagian');
        

         // sub bagian
        Route::get('/sub_bagian', [SubBagianController::class, 'index'])->name('subbagian');
        Route::get('/getDataSubBagian', [SubBagianController::class, 'getDataSubBagian'])->name('getDataSubBagian');
        Route::post('/subbagianSave', [SubBagianController::class, 'save'])->name('subbagianSave');
        Route::get('/subbagianEdit{id}', [SubBagianController::class, 'edit'])->name('subbagianEdit');
        Route::get('/getBagianselected{id}', [SubBagianController::class, 'getBagianselected'])->name('getBagianselected');
        Route::post('/subBagianUpdate', [SubBagianController::class, 'update'])->name('subBagianUpdate');
        Route::get('/confrimdelsubbag{id}', [SubBagianController::class, 'confrimdelsubbag'])->name('confrimdelsubbag');
        Route::get('/deletebagiansub{id}', [SubBagianController::class, 'delete'])->name('deletebagiansub');


        // DataMerkController\

        Route::get('/get_data_Merk', [DataMerkController::class, 'get_data_Merk'])->name('get_data_Merk');
        Route::get('/data_merk', [DataMerkController::class, 'index'])->name('data_merk');
        Route::post('/data_save_merk', [DataMerkController::class, 'save'])->name('data_save_merk');
        Route::get('/data_merk_edit{id}', [DataMerkController::class, 'edit'])->name('data_merk_edit');
        Route::post('/data_Merk_update', [DataMerkController::class, 'update'])->name('data_Merk_update');
        Route::get('/confrimdelMerk{id}', [DataMerkController::class, 'confrimDelete'])->name('confrimdelMerk');
        Route::get('/deleteMerk{id}', [DataMerkController::class, 'delete'])->name('deleteMerk');


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

    Route::group(['prefix' => 'm_data/perangkat'], function () {
        // perangkat
        Route::get('/', [DataPerangkatController::class, 'index'])->name('perangkat');
        Route::get('/getDataPerangkat', [DataPerangkatController::class, 'getDataPerangkat'])->name('getDataPerangkat');
        Route::get('/add', [DataPerangkatController::class, 'tambah'])->name('add_perangkat');
        Route::post('/save', [DataPerangkatController::class, 'save'])->name('save_perangkat');
        Route::get('/edit/{id}', [DataPerangkatController::class, 'edit'])->name('edit_perangkat');
        Route::post('/update/{id}', [DataPerangkatController::class, 'update'])->name('update_perangkat');
        Route::get('/confrimdelperangkat/{id}', [DataPerangkatController::class, 'confrimDelete'])->name('confrimdelperangkat');
        Route::get('/delete/{id}', [DataPerangkatController::class, 'delete'])->name('delete_perangkat');
    });

    Route::group(['prefix' => 'm_data/aplikasi'], function () {
        // aplikasi
        Route::get('/', [DataAplikasiController::class, 'index'])->name('aplikasi');
        Route::get('/getDataAplikasi', [DataAplikasiController::class, 'getDataAplikasi'])->name('getDataAplikasi');
        Route::get('/add', [DataAplikasiController::class, 'tambah'])->name('add_Aplikasi');
        Route::post('/save', [DataAplikasiController::class, 'save'])->name('save_Aplikasi');
        Route::get('/edit/{id}', [DataAplikasiController::class, 'edit'])->name('edit_Aplikasi');
        Route::post('/update/{id}', [DataAplikasiController::class, 'update'])->name('update_Aplikasi');
        Route::get('/confrimdelAplikasi/{id}', [DataAplikasiController::class, 'confrimDelete'])->name('confrimdelAplikasi');
        Route::get('/delete/{id}', [DataAplikasiController::class, 'delete'])->name('delete_Aplikasi');
    });
    
    Route::group(['prefix' => 'm_data/alat_kantor'], function () {
        // alat_kantor
        Route::get('/', [DataAlatKantorController::class, 'index'])->name('aplikasi');
        Route::get('/getDataAtk', [DataAlatKantorController::class, 'getDataAtk'])->name('getDataAtk');
        Route::get('/add', [DataAlatKantorController::class, 'tambah'])->name('add_Atk');
        Route::post('/save', [DataAlatKantorController::class, 'save'])->name('save_Atk');
        Route::get('/edit/{id}', [DataAlatKantorController::class, 'edit'])->name('edit_Atk');
        Route::post('/update/{id}', [DataAlatKantorController::class, 'update'])->name('update_Atk');
        Route::get('/confrimdelAtk/{id}', [DataAlatKantorController::class, 'confrimDelete'])->name('confrimdelAtk');
        Route::get('/delete/{id}', [DataAlatKantorController::class, 'delete'])->name('delete_Atk');
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
        Route::get('/detail/{id}/{id_trs}', [TransaksiPerangkatController::class, 'detail'])->name('detail_trs');
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
        Route::get('/detail/{id}/{id_trs}', [TransaksiAplikasiController::class, 'detail'])->name('detail_trs_aplikasi');
        Route::get('/edit/{id}', [TransaksiAplikasiController::class, 'edit'])->name('edit_trs_aplikasi');
        Route::post('/update/{id}', [TransaksiAplikasiController::class, 'update'])->name('update_trs_aplikasi');
        Route::get('/getSubBagian', [TransaksiAplikasiController::class, 'getSubBagian'])->name('getSubBagian');
    });

// trs aplikasi
    Route::group(['prefix' => 'transaksi_data/p_kantor_trans'], function () {
        Route::get('/', [TransaksiAlatKantor::class, 'index'])->name('trs_aplikasi');
        Route::get('/add', [TransaksiAlatKantor::class, 'tambah'])->name('add_trs_alat_kantor');
        Route::get('/getTrsAtk', [TransaksiAlatKantor::class, 'getTrsAtk'])->name('getTrsAtk');
        Route::get('/gatAtk', [TransaksiAlatKantor::class, 'gatAtk'])->name('gatAtk');
        Route::post('/save', [TransaksiAlatKantor::class, 'save'])->name('save_trs_atk');
        Route::get('/detail/{id}/{id_trs}', [TransaksiAlatKantor::class, 'detail'])->name('detail_trs_atk');
        Route::get('/edit/{id}', [TransaksiAlatKantor::class, 'edit'])->name('edit_trs_atk');
        Route::post('/update/{id}', [TransaksiAlatKantor::class, 'update'])->name('update_trs_atk');
        Route::get('/getSubBagian', [TransaksiAlatKantor::class, 'getSubBagian'])->name('getSubBagian');
    });


    // trs aplikasi
    Route::group(['prefix' => 'transaksi_data/invtentaris_trans'], function () {
        Route::get('/', [TransaksiInvController::class, 'index'])->name('trsInv');
        Route::get('/add', [TransaksiInvController::class, 'tambah'])->name('add_trsInv');
        Route::get('/getTrsInv', [TransaksiInvController::class, 'getTrsInv'])->name('getTrsInv');
        Route::get('/gatInv', [TransaksiInvController::class, 'gatInv'])->name('gatInv');
        Route::post('/save', [TransaksiInvController::class, 'save'])->name('save_trsInv');
        Route::get('/detail/{id}/{id_trs}', [TransaksiInvController::class, 'detail'])->name('detail_trsInv');
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
        Route::get('/detail/{id}/{trs_id}', [PengembalianController::class, 'detail'])->name('detailkembali');
        Route::get('/edit/{id}/{trs_id}', [PengembalianController::class, 'edit'])->name('editKembali');
        Route::post('/update/{id}', [PengembalianController::class, 'update'])->name('update_kembali');
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
    });

    Route::group(['prefix' => 'laporan_nominatif/'], function () {
        Route::get('/lap_perangkat', [LaporanPerangkat::class, 'perangkat'])->name('perangkat');
        Route::get('/lap_perangkat_excel', [LaporanPerangkat::class, 'perangkat_excel'])->name('perangkat_excel');
        Route::get('/lap_prangkat_gedung', [LaporanPerangkat::class, 'perangkatPergedung'])->name('perangkatPergedung');
        Route::get('/perangkatPergedung_excel', [LaporanPerangkat::class, 'perangkatPergedung_excel'])->name('perangkatPergedung_excel');
        Route::get('/lap_prangkat_ruang', [LaporanPerangkat::class, 'perangkatPerRuangan'])->name('perangkatPerRuangan');
        Route::get('/perangkatPerRuangan_excel', [LaporanPerangkat::class, 'perangkatPerRuangan_excel'])->name('perangkatPerRuangan_excel');
        Route::get('/lap_prangkat_kon', [LaporanPerangkat::class, 'perangkatPerKondisi'])->name('perangkatPerKondisi');
        Route::get('/perangkatPerKondisi_excel', [LaporanPerangkat::class, 'perangkatPerKondisi_excel'])->name('perangkatPerKondisi_excel');


        // aplikasi
        Route::get('/lap_aplikasi', [AplikasiLaporan::class, 'aplikasi'])->name('aplikasi_laporan');
        Route::get('/lap_aplikasi_excel', [AplikasiLaporan::class, 'aplikasi_excel'])->name('aplikasi_excel');
        Route::get('/lap_apl_gedung', [AplikasiLaporan::class, 'aplikasiPergedung'])->name('aplikasiPergedung');
        Route::get('/aplikasiPergedung_excel', [AplikasiLaporan::class, 'aplikasiPergedung_excel'])->name('aplikasiPergedung_excel');
        Route::get('/lap_apl_ruangan', [AplikasiLaporan::class, 'aplikasiPerRuangan'])->name('aplikasiPerRuangan');
        Route::get('/aplikasiPerRuangan_excel', [AplikasiLaporan::class, 'aplikasiPerRuangan_excel'])->name('aplikasiPerRuangan_excel');
        Route::get('/lap_apl_kon', [AplikasiLaporan::class, 'aplikasiPerKondisi'])->name('aplikasiPerKondisi');
        Route::get('/aplikasiPerKondisi_excel', [AplikasiLaporan::class, 'aplikasiPerKondisi_excel'])->name('aplikasiPerKondisi_excel');


        // alat kantor
        Route::get('/lap_alat_kantor', [LaporanAlatKantor::class, 'alatKantor'])->name('laporan_alatKantor');
        Route::get('/lap_alatKantor_excel', [LaporanAlatKantor::class, 'alatkantor_excel'])->name('alatkantor_excel');
        Route::get('/lap_alat_gedung', [LaporanAlatKantor::class, 'alatKantorPergedung'])->name('alatKantorPergedung');
        Route::get('/alatKantorPergedung_excel', [LaporanAlatKantor::class, 'alatKantorPergedung_excel'])->name('alatKantorPergedung_excel');
        Route::get('/lap_alat_ruang', [LaporanAlatKantor::class, 'alatKantorPerRuangan'])->name('alatKantorPerRuangan');
        Route::get('/alatKantorPerRuangan_excel', [LaporanAlatKantor::class, 'alatKantorPerRuangan_excel'])->name('alatKantorPerRuangan_excel');
        Route::get('/lap_alat_kondisi', [LaporanAlatKantor::class, 'alatKantorPerKondisi'])->name('alatKantorPerKondisi');
        Route::get('/alatKantorPerKondisi_excel', [LaporanAlatKantor::class, 'alatKantorPerKondisi_excel'])->name('alatKantorPerKondisi_excel');
        
        
        // LaporanInventaris

        Route::get('/lap_inv', [LaporanInventaris::class, 'inventaris'])->name('lap_inv');
        Route::get('/lap_inventaris_excel', [LaporanInventaris::class, 'inventaris_excel'])->name('inventaris_excel');
        Route::get('/lap_inv_gedung', [LaporanInventaris::class, 'inventarisPergedung'])->name('inventarisPergedung');
        Route::get('/inventarisPergedung_excel', [LaporanInventaris::class, 'inventarisPergedung_excel'])->name('inventarisPergedung_excel');
        Route::get('/lap_inv_ruang', [LaporanInventaris::class, 'inventarisPerRuangan'])->name('inventarisPerRuangan');
        Route::get('/inventarisPerRuangan_excel', [LaporanInventaris::class, 'inventarisPerRuangan_excel'])->name('inventarisPerRuangan_excel');
        Route::get('/lap_inv_kon', [LaporanInventaris::class, 'inventarisPerKondisi'])->name('inventarisPerKondisi');
        Route::get('/inventarisPerKondisi_excel', [LaporanInventaris::class, 'inventarisPerKondisi_excel'])->name('inventarisPerKondisi_excel');
    });

    Route::group(['prefix' => 'laporan_mutasi/'], function () {
        Route::get('/mut_prangkat', [LaporanMutasi::class, 'index'])->name('mut_prangkat');
        Route::get('/mut_prangkat_excel', [LaporanMutasi::class, 'mut_prangkat_excel'])->name('mut_prangkat_excel');
        Route::get('/mut_prangkat_gedung', [LaporanMutasi::class, 'mut_prangkat_gedung'])->name('mut_prangkat_gedung');
        Route::get('/mut_prangkat_gedung_excel', [LaporanMutasi::class, 'mut_prangkat_gedung_excel'])->name('mut_prangkat_gedung_excel');
        Route::get('/mut_prangkat_ruang', [LaporanMutasi::class, 'mut_prangkat_ruangan'])->name('mut_prangkat_ruangan');
        Route::get('/mut_prangkat_ruangan_excel', [LaporanMutasi::class, 'mut_prangkat_ruangan_excel'])->name('mut_prangkat_ruangan_excel');
        
        // aplikasi
        Route::get('/mut_aplikasi', [LaporanMutasi::class, 'aplikasi'])->name('mut_aplikasi');
        Route::get('/mut_aplikasi_excel', [LaporanMutasi::class, 'mut_aplikasi_excel'])->name('mut_aplikasi_excel');
        Route::get('/mut_apl_gedung', [LaporanMutasi::class, 'mut_aplikasi_gedung'])->name('mut_aplikasi_gedung');
        Route::get('/mut_aplikasi_gedung_excel', [LaporanMutasi::class, 'mut_aplikasi_gedung_excel'])->name('mut_aplikasi_gedung_excel');
        Route::get('/mut_apl_ruang', [LaporanMutasi::class, 'mut_aplikasi_ruangan'])->name('mut_aplikasi_ruangan');
        Route::get('/mut_aplikasi_ruangan_excel', [LaporanMutasi::class, 'mut_aplikasi_ruangan_excel'])->name('mut_aplikasi_ruangan_excel');


        // aplikasi
        Route::get('/mut_atk', [LaporanMutasi::class, 'AlatKantor'])->name('mut_AlatKantor');
        Route::get('/mut_AlatKantor_excel', [LaporanMutasi::class, 'mut_AlatKantor_excel'])->name('mut_AlatKantor_excel');
        Route::get('/mut_atk_gedung', [LaporanMutasi::class, 'mut_AlatKantor_gedung'])->name('mut_AlatKantor_gedung');
        Route::get('/mut_AlatKantor_gedung_excel', [LaporanMutasi::class, 'mut_AlatKantor_gedung_excel'])->name('mut_AlatKantor_gedung_excel');
        Route::get('/mut_atk_ruang', [LaporanMutasi::class, 'mut_AlatKantor_ruangan'])->name('mut_AlatKantor_ruangan');
        Route::get('/mut_AlatKantor_ruangan_excel', [LaporanMutasi::class, 'mut_AlatKantor_ruangan_excel'])->name('mut_AlatKantor_ruangan_excel');

        // inventaris
        Route::get('/mut_inv', [LaporanMutasi::class, 'Inv'])->name('mut_Inv');
        Route::get('/mut_Inv_excel', [LaporanMutasi::class, 'mut_Inv_excel'])->name('mut_Inv_excel');
        Route::get('/mut_inv_gedung', [LaporanMutasi::class, 'mut_Inv_gedung'])->name('mut_Inv_gedung');
        Route::get('/mut_Inv_gedung_excel', [LaporanMutasi::class, 'mut_Inv_gedung_excel'])->name('mut_Inv_gedung_excel');
        Route::get('/mut_inv_ruang', [LaporanMutasi::class, 'mut_Inv_ruangan'])->name('mut_Inv_ruangan');
        Route::get('/mut_Inv_ruangan_excel', [LaporanMutasi::class, 'mut_Inv_ruangan_excel'])->name('mut_Inv_ruangan_excel');
    });


    Route::group(['prefix' => 'lap_pengembalian/'], function () {
        // perangkat
        Route::get('/kem_prangkat', [LaporanPengembalian::class, 'index'])->name('kem_prangkat');
        Route::get('/kem_prangkat_excel', [LaporanPengembalian::class, 'kem_prangkat_excel'])->name('kem_prangkat_excel');
        Route::get('/kem_prangkat_gedung', [LaporanPengembalian::class, 'kem_prangkat_gedung'])->name('kem_prangkat_gedung_');
        Route::get('/kem_prangkat_gedung_excel', [LaporanPengembalian::class, 'kem_prangkat_gedung_excel'])->name('kem_prangkat_gedung_excel');
        Route::get('/kem_prangkat_ruang', [LaporanPengembalian::class, 'kem_prangkat_ruang'])->name('kem_prangkat_ruang');
        Route::get('/kem_prangkat_ruang_excel', [LaporanPengembalian::class, 'kem_prangkat_ruang_excel'])->name('kem_prangkat_ruang_excel');
        
        // aplikasi
         Route::get('/kem_aplikasi', [LaporanPengembalian::class, 'aplikasi'])->name('kem_aplikasi');
        Route::get('/kem_aplikasi_excel', [LaporanPengembalian::class, 'kem_aplikasi_excel'])->name('kem_aplikasi_excel');
        Route::get('/kem_aplikasi_gedung', [LaporanPengembalian::class, 'kem_aplikasi_gedung'])->name('kem_aplikasi_gedung_');
        Route::get('/kem_aplikasi_gedung_excel', [LaporanPengembalian::class, 'kem_aplikasi_gedung_excel'])->name('kem_aplikasi_gedung_excel');
        Route::get('/kem_aplikasi_ruang', [LaporanPengembalian::class, 'kem_aplikasi_ruang'])->name('kem_aplikasi_ruang');
        Route::get('/kem_aplikasi_ruang_excel', [LaporanPengembalian::class, 'kem_aplikasi_ruang_excel'])->name('kem_aplikasi_ruang_excel');


       // kembali
        Route::get('/kem_atk', [LaporanPengembalian::class, 'atk'])->name('kem_atk');
        Route::get('/kem_atk_excel', [LaporanPengembalian::class, 'kem_atk_excel'])->name('kem_atk_excel');
        Route::get('/kem_atk_gedung', [LaporanPengembalian::class, 'kem_atk_gedung'])->name('kem_atk_gedung_');
        Route::get('/kem_atk_gedung_excel', [LaporanPengembalian::class, 'kem_atk_gedung_excel'])->name('kem_atk_gedung_excel');
        Route::get('/kem_atk_ruang', [LaporanPengembalian::class, 'kem_atk_ruang'])->name('kem_atk_ruang');
        Route::get('/kem_atk_ruang_excel', [LaporanPengembalian::class, 'kem_atk_ruang_excel'])->name('kem_atk_ruang_excel');

       
        // inv
         Route::get('/kem_inv', [LaporanPengembalian::class, 'inv'])->name('kem_inv');
        Route::get('/kem_inv_excel', [LaporanPengembalian::class, 'kem_inv_excel'])->name('kem_inv_excel');
        Route::get('/kem_inv_gedung', [LaporanPengembalian::class, 'kem_inv_gedung'])->name('kem_inv_gedung_');
        Route::get('/kem_inv_gedung_excel', [LaporanPengembalian::class, 'kem_inv_gedung_excel'])->name('kem_inv_gedung_excel');
        Route::get('/kem_inv_ruang', [LaporanPengembalian::class, 'kem_inv_ruang'])->name('kem_inv_ruang');
        Route::get('/kem_inv_ruang_excel', [LaporanPengembalian::class, 'kem_inv_ruang_excel'])->name('kem_inv_ruang_excel');
    });


    // RekapitulasiData
    
    Route::group(['prefix' => 'lap_rekap/'], function () {

         Route::get('/rekap_lap_gedung', [RekapitulasiData::class, 'rekapPerangkatGedung'])->name('rekapPerangkatGedung');
         Route::get('/rekap_lap_gedung_excel', [RekapitulasiData::class, 'rekapPerangkatGedungExcel'])->name('rekapPerangkatGedungExcel');
         Route::get('/rekap_perangkat_ruang', [RekapitulasiData::class, 'rekapPerangkatRuang'])->name('rekapPerangkatRuang');
         Route::get('/rekap_perangkat_ruang_excel', [RekapitulasiData::class, 'rekapPerangkatRuangExcel'])->name('rekapPerangkatRuangExcel');

         Route::get('/rekap_lap_apl_gedung', [RekapitulasiData::class, 'rekapAplGedung'])->name('rekapAplGedung');
         Route::get('/rekap_lap_apl_gedung_excel', [RekapitulasiData::class, 'rekapAplGedungExcel'])->name('rekapAplGedungExcel');
         Route::get('/rekap_apl_ruang', [RekapitulasiData::class, 'rekapAplRuang'])->name('rekapAplRuang');
         Route::get('/rekap_apl_ruang_excel', [RekapitulasiData::class, 'rekapAplRuangExcel'])->name('rekapAplRuangExcel');

         Route::get('/rekap_atk_gedung', [RekapitulasiData::class, 'rekapAtkGedung'])->name('rekapAtkGedung');
         Route::get('/rekap_atk_gedung_excel', [RekapitulasiData::class, 'rekapAtkGedungExcel'])->name('rekapAtkGedungExcel');
         Route::get('/rekap_atk_ruang', [RekapitulasiData::class, 'rekapAtkRuang'])->name('rekapAtkRuang');
         Route::get('/rekap_atk_ruang_excel', [RekapitulasiData::class, 'rekapAtkRuangExcel'])->name('rekapAtkRuangExcel_');

         Route::get('/rekap_inv_gedung', [RekapitulasiData::class, 'rekapInvGedung'])->name('rekapInvGedung');
         Route::get('/rekap_inv_gedung_excel', [RekapitulasiData::class, 'rekapInvGedungExcel'])->name('rekapInvGedungExcel');
         Route::get('/rekap_inv_ruang', [RekapitulasiData::class, 'rekapInvRuang'])->name('rekapInvRuang');
         Route::get('/rekap_inv_ruang_excel', [RekapitulasiData::class, 'rekapInvRuangExcel'])->name('rekapInvRuangExcel_');

         Route::get('/rekap_mut_prangkat', [RekapitulasiData::class, 'mutasiperangkat'])->name('mutasiperangkat');
         Route::get('/rekap_mut_prangkat_excel', [RekapitulasiData::class, 'mutasiperangkatExcel'])->name('mutasiperangkatExcel');
         Route::get('/rekap_mut_aplikasi', [RekapitulasiData::class, 'mutasiaplikasi'])->name('mutasiaplikasi');
         Route::get('/rekap_mut_aplikasi_excel', [RekapitulasiData::class, 'mutasiaplikasiExcel'])->name('mutasiaplikasiExcel');
         Route::get('/rekap_mut_atk', [RekapitulasiData::class, 'mutasiatk'])->name('mutasiatk');
         Route::get('/rekap_mut_atk_excel', [RekapitulasiData::class, 'mutasiatkExcel'])->name('mutasiatkExcel');
         Route::get('/rekap_mut_inv', [RekapitulasiData::class, 'mutasiInv'])->name('rekap_mut_inv');
         Route::get('/rekap_mut_inv_excel', [RekapitulasiData::class, 'mutasiInvExcel'])->name('mutasiInvExcel');


         Route::get('/rekap_kembali_prkt', [RekapitulasiData::class, 'kem_prangkat_perangkat'])->name('kem_prangkat_rekap');
         Route::get('/rekap_kembali_prkt_excel', [RekapitulasiData::class, 'kem_prangkat_excel'])->name('kem_prangkat_excel');
         Route::get('/rekap_kembali_apl', [RekapitulasiData::class, 'rekap_kem_aplikasi'])->name('rekap_kem_aplikasi');
         Route::get('/rekap_kembali_apl_excel', [RekapitulasiData::class, 'rekap_kem_aplikasi_excel'])->name('rekap_kem_aplikasi_excel');
         Route::get('/rekap_kembali_atk', [RekapitulasiData::class, 'rekap_kem_atk'])->name('rekap_kem_atk');
         Route::get('/rekap_kembali_atk_excel', [RekapitulasiData::class, 'rekap_kem_atkExcel'])->name('rekap_kem_atkExcel');
         Route::get('/rekap_kmbali_inv', [RekapitulasiData::class, 'rekap_kem_inv'])->name('rekap_kem_inv');
         Route::get('/rekap_kmbali_inv_excel', [RekapitulasiData::class, 'rekap_kem_invExcel'])->name('rekap_kem_invExcel');
         
        });
    Route::group(['prefix' => 'lap_grafik/'], function () {
            
        Route::get('/grafik_prkt_gedung', [LaporanGrafik::class, 'grafik_prkt_gedung'])->name('grafik_prkt_gedung');
        Route::get('/grafik_prkt_ruang', [LaporanGrafik::class, 'grafik_prkt_ruang'])->name('grafik_prkt_ruang');
        Route::get('/grafik_apl_gedung', [LaporanGrafik::class, 'grafik_apl_gedung'])->name('grafik_apl_gedung');
        Route::get('/grafik_apl_ruang', [LaporanGrafik::class, 'grafik_apl_ruang'])->name('grafik_apl_ruang');
        Route::get('/grafik_atk_gedung', [LaporanGrafik::class, 'grafik_atk_gedung'])->name('grafik_atk_gedung');
        Route::get('/grafik_atk_ruang', [LaporanGrafik::class, 'grafik_atk_ruang'])->name('grafik_atk_ruang');
        Route::get('/grafik_inv_gedung', [LaporanGrafik::class, 'grafik_inv_gedung'])->name('grafik_inv_gedung');
        Route::get('/grafik_inv_ruang', [LaporanGrafik::class, 'grafik_inv_ruang'])->name('grafik_inv_ruang');
        Route::get('/grafik_mut_prkt', [LaporanGrafik::class, 'grafik_mut_prkt'])->name('grafik_mut_prkt');
        Route::get('/grafik_mut_apl', [LaporanGrafik::class, 'grafik_mut_apl'])->name('grafik_mut_apl');
        Route::get('/grafik_mut_atk', [LaporanGrafik::class, 'grafik_mut_atk'])->name('grafik_mut_atk');
        Route::get('/grafik_mut_inv', [LaporanGrafik::class, 'grafik_mut_inv'])->name('grafik_mut_inv');

        Route::get('/grafik_kembali_prkt', [LaporanGrafik::class, 'grafik_kembali_prkt'])->name('grafik_kembali_prkt');
        Route::get('/grafik_kembali_apl', [LaporanGrafik::class, 'grafik_kembali_apl'])->name('grafik_kembali_apl');
        Route::get('/grafik_kembali_atk', [LaporanGrafik::class, 'grafik_kembali_atk'])->name('grafik_kembali_atk');
        Route::get('/grafik_kembali_inv', [LaporanGrafik::class, 'grafik_kembali_inv'])->name('grafik_kembali_inv');
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
