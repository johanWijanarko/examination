<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class SiteHelpers
{
	public static function cekakses()
	{
	}

	public static function main_menu()
	{
		$main_menu = DB::table('menu')
			->where('master_menu',  0)
			->orderBy('no_urut', 'asc')
			->where('status', 1)
			->get();
		return $main_menu;
	}

	public static function sub_menu()
	{
		$sub_menu = DB::table('menu')
			->where('master_menu', '>', 0)
			->where('status', 1)
			->orderBy('no_urut', 'asc')
			->get();
		return $sub_menu;
	}

	public static function login_API()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://103.82.242.14/api/client/auth/login',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'username=sufry&password=sufry',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// echo $response;
		$decodeLogin = json_decode($response);
		return  $decodeLogin->_token_;
	}

	public static function send_wa($handphone, $text)
	{
		if ($handphone == null || $handphone == '' || $handphone == 0) {
			$output = false;
		} else {

			$token = static::login_API();

			// $text      = rawurlencode($text);
			$handphone = preg_replace('/\D/', '', $handphone);
			$subs      = substr($handphone, 1);
			$depan     = substr($handphone, 0, 1);
			if ($depan == "0") {
				$handphone = "62" . $subs;
			}

			if ($depan == "8") {
				$handphone = "628" . $subs;
			}
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://103.82.242.14/api/assistant/message/text/notification',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => "phone=${handphone}&message=${text}",



				CURLOPT_HTTPHEADER => array(
					'_token_: ' . $token,
					'assistant_id: 9c457732-8db2-4ebb-a358-9ea60927dce5',
					'secret_key: 2abb888505d872080e5064c7093abec03ea31a673dbd8d3b670586a5a762db516453b805c5733f36bc760fefccf71f819548ba0c60f85e2d610067507bc4fd8c',
					'Content-Type: application/x-www-form-urlencoded',
					'preview_url: true',
				),
			));

			$response = curl_exec($curl);
			// dd($response);

			curl_close($curl);
			$output = $response;
		}

		return $output;

		// api wa zuwinda
		// $time = Carbon::now()->toTimeString();
        // $date= Carbon::now()->toDateString();
        // $instances_id="f7b351e0-4af1-4902-b30f-925fc45728e5";
        // $content ="cek bro cek cek, cek terakhir mar";
        // $to="62895424011865";
        // $curl = curl_init();
        
        // curl_setopt_array($curl, [
        //   CURLOPT_URL => "https://api.zuwinda.com/v1.2/message/whatsapp/send-text",
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => "",
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 30,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => "POST",
         
        //   CURLOPT_POSTFIELDS => "time=${time}&date=${date}&instances_id=${instances_id}&content=${content}&to=${to}",
        //   CURLOPT_HTTPHEADER => [
            
        //     "x-access-key: f81376da73b94a95b0aeb3cb9c4c8728"
        //   ],
        // ]);
        
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        
        // curl_close($curl);
        
        // if ($err) {
        //   echo "cURL Error #:" . $err;
        // } else {
        //   echo $response;
        // }
	    //     dd($response);
	}

	public static function get_mime_type($filename)
	{
		$idx = explode('.', $filename);
		$count_explode = count($idx);
		$idx = strtolower($idx[$count_explode - 1]);

		$mimet = array(
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',
			'mp4' => 'video/mp4',

			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			'docx' => 'application/msword',
			'xlsx' => 'application/vnd.ms-excel',
			'pptx' => 'application/vnd.ms-powerpoint',


			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		if (isset($mimet[$idx])) {
			return $mimet[$idx];
		} else {
			return 'application/octet-stream';
		}
	}

	public static function get_title_page($url)
	{
		$sql = "select * from menu where url = '$url'";
		$data = DB::select($sql);
		return @$data[0]->nama_menu;
	}

	public static function explode_list($data)
	{
		$data = explode(';', $data);
		$html = '';
		for ($i = 0; $i < count($data) - 1; $i++) {
			$no = $i + 1;
			$html .= "<li>" . $data[$i] . ".</li>";
		}
		return $html;
	}
	public static function date_table($data)
	{
		$data = explode('-', $data);
		$html = $data[2] . '-' . $data[1] . '-' . $data[0];
		return $html;
	}
	public static function rupiah($angka)
	{
		$rupiah = "Rp. " . number_format($angka, 2, ',', '.');
		return $rupiah;
	}
	public static function rupiah_number($angka)
	{
		$rupiah = number_format($angka, 0, ',', '.');
		return $rupiah;
	}
	public static function rupiah_trim($angka)
	{
		$rupiah = str_replace('.', '', $angka);
		return $rupiah;
	}
	public static function remove_p($html)
	{
		$html = str_replace('<p>', '', $html);
		$html = str_replace('</p>', '', $html);
		return $html;
	}
	public static function date_indo($tanggal)
	{
		// cek
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$split = explode('-', $tanggal);
		return @$split[2] . ' ' . @$bulan[(int)@$split[1]] . ' ' . @$split[0];
	}
	public static function date_bulan($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$split = explode('-', $tanggal);
		return @$bulan[(int)@$split[1]];
	}
	public static function date_time_indo($tanggal)
	{
		// cek
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$date_time = explode(' ', $tanggal);
		$split = explode('-', $date_time[0]);
		return @$split[2] . ' ' . @$bulan[(int)@$split[1]] . ' ' . @$split[0];
	}
	public static function date_db($tanggal)
	{
		$split = explode('/', $tanggal);
		return @$split[2] . '-' . @$split[1] . '-' . @$split[0];
	}
	public static function date_app($tanggal)
	{
		$split = explode('-', $tanggal);
		return @$split[2] . '/' . @$split[1] . '/' . @$split[0];
	}
	public static function get_detail_auditor($user_id)
	{
		$data = DB::table('users')->leftjoin('auditor', 'auditor.auditor_id', '=', 'users.user_internal_id')->where('id', $user_id)->first();
		return $data;
	}
	public static function get_posisi_penugasan($assign_id, $auditor_id)
	{
		$data = DB::table('audit_assign_auditor')->select('jenis_jabatan_kode')
			->join('auditor', 'auditor.auditor_id', '=', 'assign_auditor_id_auditor')
			->join('par_jenis_jabatan', 'assign_auditor_posisi_id', '=', 'jenis_jabatan_id')
			->where('assign_auditor_id_assign', $assign_id)
			->where('assign_auditor_id_auditor', $auditor_id)->first();
		// dd($data);
		if ($data == null) {
			$data == '';
		} else {
			$data = $data->jenis_jabatan_kode;
		}
		return $data;
	}
	public static function get_jabatan_auditor($auditor_id)
	{
		$data = DB::table('auditor')->select('jenis_jabatan_name')
			->join('par_jenis_jabatan', 'auditor_id_jabatan', '=', 'jenis_jabatan_id')
			->where('auditor_id', $auditor_id)->first();
		// dd($data);
		if ($data == null) {
			$data == '';
		} else {
			$data = $data->jenis_jabatan_name;
		}
		return $data;
	}
	public static function count_actionplan_null($assign_id)
	{
		$data = DB::select("SELECT COUNT(*) as jumlah_action_plan FROM audit_assign_rekomendasi 
    INNER JOIN audit_assign_temuan ON audit_assign_temuan.assign_temuan_id = audit_assign_rekomendasi.assign_rekomendasi_temuan_id
    WHERE audit_assign_temuan.assign_temuan_status = '6' AND audit_assign_temuan.assign_temuan_disposisi_status = '1' AND audit_assign_temuan.assign_temuan_assign_id = '$assign_id'
    AND (assign_rekomendasi_actionplan is null OR assign_rekomendasi_actionplan = '')");
		// dd($data[0]->jumlah_action_plan);
		if ($data[0] == NULL) {
			$data = 0;
		} else {
			$data = $data[0]->jumlah_action_plan;
		}
		return $data;
	}

	public static function count_program_by_assign_status($assign_id, $status = 0)
	{
		$data = DB::select("SELECT COUNT(*) as jumlah FROM audit_assign_program WHERE assign_program_assign_id = '$assign_id' AND assign_program_status IN('$status')");
		if ($data[0] == NULL) {
			$data = 0;
		} else {
			$data = $data[0]->jumlah;
		}
		return $data;
	}
	public static function count_kka_by_assign_status($assign_id, $status = 0)
	{
		$data = DB::select("SELECT COUNT(*) as jumlah FROM audit_assign_kka 
				INNER JOIN audit_assign_jenis_kka ON assign_kka_jenis_id = jenis_kka_id
				INNER JOIN audit_assign_program_prosedur ON jenis_kka_prosedur_id = assign_program_prosedur_id
				INNER JOIN audit_assign_program ON assign_program_prosedur_program_id = assign_program_id
				WHERE assign_program_assign_id = '$assign_id' AND assign_kka_status IN('$status')");
		if ($data[0] == NULL) {
			$data = 0;
		} else {
			$data = $data[0]->jumlah;
		}
		return $data;
	}
	public static function count_temuan_by_assign_status($assign_id, $status = 0)
	{
		$data = DB::select("SELECT COUNT(*) as jumlah FROM audit_assign_temuan WHERE assign_temuan_assign_id = '$assign_id' AND assign_temuan_status IN('$status')");
		if ($data[0] == NULL) {
			$data = 0;
		} else {
			$data = $data[0]->jumlah;
		}
		return $data;
	}
	public static function count_temuan_disposisi_by_assign_status($assign_id, $status = 6)
	{
		$data = DB::select("SELECT COUNT(*) as jumlah FROM audit_assign_temuan WHERE assign_temuan_assign_id = '$assign_id' AND assign_temuan_status IN('$status') AND assign_temuan_disposisi_status = '1'");
		if ($data[0] == NULL) {
			$data = 0;
		} else {
			$data = $data[0]->jumlah;
		}
		return $data;
	}
    
    public static function plan_get_tim($plan_id, $auditor_id, $as_posisi = 'SM')
    {
        $posisi_kode = DB::table('audit_plan_auditor')->select('jenis_jabatan_kode')
        ->leftjoin('auditor', 'auditor_id', '=', 'plan_auditor_id_auditor')
        ->leftjoin('audit_plan', 'plan_auditor_id_plan', '=', 'audit_plan_id')
        ->leftjoin('par_jenis_jabatan', 'jenis_jabatan_id', '=', 'plan_auditor_posisi_id')
        ->where('audit_plan_id', '=', $plan_id)
        ->where('plan_auditor_id_auditor', '=', $auditor_id)->first();
		if($posisi_kode == null){
			return false;
		}else{
			$posisi_kode = $posisi_kode->jenis_jabatan_kode;
			if($posisi_kode == $as_posisi){
				return true;
			}else{
				return false;
			}
		}
    }
    public static function getRoleName($user_id)
    {
        $user = User::find($user_id);
		return $user->getRoleNames();
    }

	public static function get_structure_potition_plan($plan_id, $potition_code) {
        $count_anggota = DB::table('audit_plan_auditor')->select('jenis_jabatan_kode')
        ->join('auditor', 'auditor_id', '=', 'plan_auditor_id_auditor')
        ->join('audit_plan', 'plan_auditor_id_plan', '=', 'audit_plan_id')
        ->join('par_jenis_jabatan', 'jenis_jabatan_id', '=', 'plan_auditor_posisi_id')
        ->where('audit_plan_id', '=', $plan_id)
		->where('jenis_jabatan_kode', '=', $potition_code)->count();
		// dd($count_anggota);
		if($count_anggota == 0){
			return false;
		}else{
			return true;
		}
	}
    public static function complete_structure_plan($plan_id)
    {
		$sm = self::get_structure_potition_plan($plan_id, 'SM');
		$kt = self::get_structure_potition_plan($plan_id, 'KT');
		$at = self::get_structure_potition_plan($plan_id, 'AT');
		if($sm && $kt && $at){
			return true;
		}else{
			return false;
		}
    }
	public static function get_structure_potition_assign($assign_id, $potition_code) {
        $count_anggota = DB::table('audit_assign_auditor')->select('jenis_jabatan_kode')
        ->join('auditor', 'auditor_id', '=', 'assign_auditor_id_auditor')
        ->join('audit_assign', 'assign_auditor_id_assign', '=', 'audit_assign_id')
        ->join('par_jenis_jabatan', 'jenis_jabatan_id', '=', 'assign_auditor_posisi_id')
        ->where('audit_assign_id', '=', $assign_id)
		->where('jenis_jabatan_kode', '=', $potition_code)->count();
		// dd($count_anggota);
		if($count_anggota == 0){
			return false;
		}else{
			return true;
		}
	}
	public static function auditor_get_month_assign($auditor_id, $bulan, $tahun) {
        $count_penugasan = collect(DB::SELECT("SELECT COUNT(*) AS jumlah FROM audit_assign 
		INNER JOIN audit_assign_auditor ON audit_assign.audit_assign_id = audit_assign_auditor.assign_auditor_id_assign 
		WHERE MONTH(audit_assign.audit_assign_start) = '$bulan' AND YEAR(audit_assign.audit_assign_start) = '$tahun' AND audit_assign_auditor.assign_auditor_id_auditor = '$auditor_id'"))->first();
		// dd($count_anggota);
		if($count_penugasan->jumlah == 0){
			return 0;
		}else{
			return $count_penugasan->jumlah;
		}
	}
    public static function complete_structure_assign($assign_id)
    {
		$sm = self::get_structure_potition_plan($assign_id, 'SM');
		$kt = self::get_structure_potition_plan($assign_id, 'KT');
		$at = self::get_structure_potition_plan($assign_id, 'AT');
		if($sm && $kt && $at){
			return true;
		}else{
			return false;
		}
    }
	public static function curr_to_dec($duit){
		if($duit != ''){
			$duit = str_replace(".", "",$duit);
			$duit = str_replace(",", ".",$duit);
			return $duit;
		}else{
			return '0.00';
		}
	}

	public static function db_to_rp($text, $null = null)
    {
        $text = strrev($text);
        $text = str_replace('.','',$text);
        $len  = str_split($text);
        
        $res = '';
        foreach($len as $key => $val) {
            if ($key==3 || $key==6 || 
                $key==9 || $key==12 ||
                $key==15 || $key==18) {
                $res .= '.'.$val;
            } else {
                $res .= $val;
            }
        }
        
        if($text != 0) {
            $res = strrev($res);
        } else {
            if($null) {
                $res = $null;
            } else {
                $res = strrev($res);
            }
        }
        return $res;
    }
}

