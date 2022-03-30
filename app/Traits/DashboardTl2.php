<?php
namespace App\Traits;

/**
 * 
 */
trait DashboardTl2 
{
    public function scopeFilterDashboard2($query, $request, $status = '')
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
                });

                })->when($status != '', function ($q) use ($status){
                    // if ($status == 5) {
                    //    $q->where('tl_eks_status', 0);
                    // } else {
                       $q->where('tl_eks_status', $status);
                    // }
                    
                });
                
    }
}
