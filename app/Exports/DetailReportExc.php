<?php

namespace App\Exports;

use App\Models\Inspeksi;
use App\Support\Collection;
use App\Models\AuditeeModel;
use Illuminate\Http\Request;
use App\Models\ParTahunModel;
use App\Models\PegawaiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\AuditeEksternalModel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\ParKategoriTemuanEksModel;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class DetailReportExc implements FromView, WithEvents
{
    use RegistersEventListeners, Exportable;
    // use WithMapping;
    // use WithStyles;
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $auditee = AuditeeModel::where('auditee_del_st', 1)->orderBy('auditee_name', 'asc')->get();
        $tahun = ParTahunModel::where('status', 1)->get();
        $jabatan = PegawaiModels::where('auditor_id_jabatan', '=', 110)->first();
        $kategori = ParKategoriTemuanEksModel::where('kategori_temuan_eks_del_st', 1)->get();

        $laporan = AuditeEksternalModel::whereHas('hasTemuans', function ($q){
                $q->when(auth()->user()->user_eksternal_id != null, function ($q) {
                    $q->whereHas('hasRekomendations', function ($q) {
                        $q->whereHas('auditees', function ($q) {
                            $q->where('pic_id', auth()->user()->user_eksternal_id);
                            $q->when($this->request->auditee, function ($q) {
                                $q->where('pic_id', '=',  $this->request->auditee);
                            });
                        });
                        $q->whereHas('hasTindakLanjuts',function ($q){
                            $q->when($this->request->status, function ($q) {
                                $q->where('tl_eks_status', '=',  $this->request->status);
                            });
                            $q->when($this->request->start || $this->request->end, function ($q) {
                                $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                            });
                        });
                    });
                })->whereHas('hasRekomendations', function ($q) {
                    $q->whereHas('auditees', function ($q) {
                        $q->when($this->request->auditee, function ($q) {
                            $q->where('pic_id', '=',  $this->request->auditee);
                        });
                    });
                    $q->whereHas('hasTindakLanjuts', function ($q) {
                        $q->when($this->request->status, function ($q) {
                            $q->where('tl_eks_status', '=',  $this->request->status);
                        });
                        $q->when($this->request->start || $this->request->end, function ($q) {
                            $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                        });
                    });
                });
            })
            ->with([
                'hasTemuans' => function ($q) {
                    $q->whereHas('hasTindakLanjuts', function ($q){
                        $q->when($this->request->status, function ($q) {
                            $q->where('tl_eks_status', '=',  $this->request->status);
                            $q->whereHas('hasAttch');
                        });
                        $q->when($this->request->start || $this->request->end, function ($q) {
                            $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                        });
                    });
                    $q->with(['hasRekomendations' => function ($q) {
                        $q->whereHas('hasTindakLanjuts', function ($q){
                            $q->when($this->request->status, function ($q) {
                                $q->where('tl_eks_status', '=',  $this->request->status);
                                $q->whereHas('hasAttch');
                            });
                            $q->when($this->request->start || $this->request->end, function ($q) {
                                $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                            });
                        });
                        $q->with(['hasTindakLanjuts' => function ($q) {
                            $q->when($this->request->status, function ($q) {
                                $q->where('tl_eks_status', '=',  $this->request->status);
                                $q->whereHas('hasAttch');
                            });
                        }]);
                        $q->withCount(['hasTindakLanjuts' => function ($q){
                            $q->when($this->request->status, function ($q) {
                                $q->where('tl_eks_status', '=',  $this->request->status);
                                $q->whereHas('hasAttch');
                            });
                            $q->when($this->request->start || $this->request->end, function ($q) {
                                $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                            });
                        }]);
                    }]);
                    $q->withCount(['hasTindakLanjuts' => function ($q) {
                        $q->when($this->request->status, function ($q) {
                            $q->where('tl_eks_status', '=',  $this->request->status);
                            $q->whereHas('hasAttch');
                        });
                        $q->when($this->request->start || $this->request->end, function ($q) {
                            $q->whereBetween('tl_eks_tanggal',[ date('Y-m-d',strtotime($this->request->start)) , date('Y-m-d',strtotime($this->request->end))]);
                        });
                    }]);
                }
            ])
            ->where('assign_eks_del_st', 1)
            ->when($this->request->tahun, function ($q) {
                $q->where('assign_eks_tahun_lhp', 'like', '%' . $this->request->tahun . '%');
            })
            ->when($this->request->ketegori, function ($q) {
                $q->where('assign_eks_kategori_temuan_id', 'like', '%' . $this->request->ketegori . '%');
            })
            ->get();
        // dd($jabatan);
        return view('laporan.tl_excel', [
            'laporan' => $laporan,
            'tahun' => $tahun,
            'jabatan' => $jabatan,
            'auditee' => $auditee,
            'kategori' => $kategori,
        ]);
        // return view('laporan.tl_excel', compact('jabatan'));
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Create Style Arrays
        $default_font_style = [
            'font' => ['name' => 'Arial', 'size' => 10],
            
        ];

        $judul = [
            'font' => ['name' => 'Arial', 'size' => 12],
        ];

        $border = [
            'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
        ];
       
        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // Apply Style Arrays
        $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

        // // strikethrough group of cells (A10 to B12) 
        $active_sheet->getStyle('A2:F2')->applyFromArray($judul);
        $active_sheet->getStyle('D3')->applyFromArray($default_font_style);
        $active_sheet->getStyle('A2:F9')->applyFromArray($border);
        
        $active_sheet->getColumnDimension('A')->setWidth(30);
        $active_sheet->getColumnDimension('B')->setWidth(70);
        $active_sheet->getColumnDimension('C')->setWidth(70);
        $active_sheet->getColumnDimension('D')->setWidth(70);
        $active_sheet->getColumnDimension('E')->setWidth(30);
        $active_sheet->getColumnDimension('F')->setWidth(50);

        for ($i = 1; $i <= 12; $i ++) {
            $active_sheet->getRowDimension($i)->setRowHeight(35);
        }
                    // $active_sheet->getRowDimension('2')->setRowHeight(30);
        // $active_sheet->getColumnDimension('B')->setHeight(20);
        // $active_sheet->getColumnDimension('C')->setHeight(20);
        // $active_sheet->getColumnDimension('D')->setHeight(20);
        // $active_sheet->getColumnDimension('E')->setHeight(20);
        // $active_sheet->getColumnDimension('F')->setHeight(20);
        // // or
        // $active_sheet->getStyle('A10:B12')->getFont()->setStrikethrough(true);

        // // single cell
        // $active_sheet->getStyle('D3')->getFont()->judul(true);
    }
}
