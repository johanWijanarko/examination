<?php

namespace App\Http\Controllers;

use App\Models\UserExam;
use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $pertanyaan = PertanyaanModel::with(['PertanyanHasJawaban'])->paginate(1);
        $pertanyaan2 = PertanyaanModel::with(['PertanyanHasJawaban'])->get();



        $pertanyaanCount = PertanyaanModel::with(['PertanyanHasJawaban'])->get();
        return view('exam.index', compact('pertanyaan', 'pertanyaanCount', 'pertanyaan2'));
    }
    public function saveJwaban(Request $request){
            //    dd(Auth::user()->id);
            $jawaban_ = $request->jawaban;
            $jawaban_ = explode('-',$jawaban_);
            $jawaban_id = (int)$jawaban_[1];
            $jawaban = $jawaban_[0];

            $checkJwaban = PertanyaanModel::where('id',$request->pertanyaan_id)->where('jawaban',$jawaban)->first();
            if($checkJwaban){
                $score = 1;
            }else{

                $score = 0;
            }

            $saveJawban = [
                'user_id' =>Auth::user()->id,
                'pertanyaan_id' =>$request->pertanyaan_id,
                'pertanyaan' =>$request->pertanyaan,
                'jawaban' =>$score,
                'jawaban_detail' =>$jawaban,
            ];
            $save = UserExam::create($saveJawban);

            return response()->json([
                'save' => $save
            ]);
       }
}
