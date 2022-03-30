<?php
namespace App\Traits;

/**
 * 
 */
trait DashboardTl 
{
    public function scopeFilterDashboard($query, $request, $status = '')
    {
        return $query->whereHas('hasRecomendation', function ($q) use ($request){
                $q->whereHas('auditees', function ($q) use ($request){
                    $q->when(auth()->user()->user_eksternal_id != null, function ($q) use ($request) {
                        $q->where('pic_id', auth()->user()->user_eksternal_id);
                    // });
                    });
                })->whereHas('temuans', function ($q) use ($request){
                        $q->whereHas('asigment', function ($q) use ($request){
                            $q->when($request->tahun, function ($q) use ($request) {
                                $q->where('assign_eks_tahun_lhp', 'like', '%' . $request->tahun . '%');
                            });
                            $q->when($request->ketegori, function ($q) use ($request) {
                                $q->where('assign_eks_kategori_temuan_id', 'like', '%' . $request->ketegori . '%');
                            });
                        });
                })->when($request->rekomend, function ($q) use ($request) {
                    $q->where('rekomendasi_eksternal_id', 'like', '%' . $request->rekomend . '%');
                });

                })->when($status != '', function ($q) use ($status){
                       $q->where('tl_eks_status', $status);
                    // }
                    
                });
                
    }
}
