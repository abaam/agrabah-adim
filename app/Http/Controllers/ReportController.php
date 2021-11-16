<?php

namespace App\Http\Controllers;

use App\Exports\Report;
use App\Loan;
use App\MarketPlace;
use App\ReverseBidding;
use App\SpotMarket;
use App\Trace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request  $request)
    {

        $row = [];
        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();
        $type = 'spot-market';
        $status = '_all';
        if(getRoleName() == 'enterprise-client'){
            $type = 'reverse-bidding';
        }
        if($request->has('mode') && $mode = $request->get('mode')){

            $type = $request->get('type');
            $start = $request->get('start');
            $end = $request->get('end');
            $status = $request->get('status');
            if(getRoleName() == 'enterprise-client'){
                $type = 'reverse-bidding';
            }

            switch ($type){
                case 'spot-market':
                    $query = SpotMarket::query();
                    break;
                case 'market-place':
                    $query = MarketPlace::query();
                    break;
                case 'reverse-bidding':
                    $query = ReverseBidding::query();
                    break;
            }
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $start = Carbon::parse($start)->toDateString();
            $end = Carbon::parse($end)->toDateString();


            if($status == 'active'){
                $query->where('status',0);
            }elseif($status == 'expired'){
                $query->where('status', 1);
            }
            $query->orderBy('created_at', 'desc');

            $row = $query->get();


            if($mode == 'download'){
                return Excel::download(new Report($row, $type), Carbon::parse($start)->format('Y-m-d').' to '.Carbon::parse($end)->format('Y-m-d').' '.ucfirst($type).'  Report.xlsx');
            }
        }

        return view('wharf.report.index', compact('row','start', 'end', 'type', 'status'));
    }

    public function traceReport(Request $request)
    {
        $input = $request->input('length');
        $lengthData = null;
        $totalData = null;
        $successData = null;
        $failedData = null;
//        $sampleData = null;

        $now = Carbon::now();
        switch ($input) {
            case 'weekly':
                $dates = [];
                $total = [];
                $success = [];
                $failed = [];
                $length = $now->endOfWeek()->diffInDays($now->copy()->startOfWeek()) +1;
                $date = $now->startOfWeek();

                for ($i = 0; $i < $length; $i++) {
                    $dates[] = $date->copy()->addDays($i)->format('D jS');
                    $total[] = Trace::whereBetween('created_at', [
                            $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                            $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                        ])
                        ->count();
                    $success[] = Trace::where('delivered', 1)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                            $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                        ])
                        ->count();
                    $failed[] = Trace::where('delivered', 0)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                            $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                        ])
                        ->count();
                }

                $lengthData = $dates;
                $totalData = $total;
                $successData = $success;
                $failedData = $failed;
                break;
            case 'monthly':
                $dates = [];
                $length = $now->endOfMonth()->diffInDays($now->copy()->startOfMonth()) +1;
                $date = $now->startOfMonth();

                for ($i = 0; $i < $length; $i++) {
                    $dates[] = $date->copy()->addDays($i)->format('D jS');
                    $total[] = Trace::whereBetween('created_at', [
                        $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                        $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                    ])
                        ->count();
                    $success[] = Trace::where('delivered', 1)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                            $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                        ])
                        ->count();
                    $failed[] = Trace::where('delivered', 0)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addDays($i)->startOfDay()->toDateTimeString(),
                            $date->copy()->addDays($i)->endOfDay()->toDateTimeString()
                        ])
                        ->count();
                }
                $lengthData = $dates;
                $totalData = $total;
                $successData = $success;
                $failedData = $failed;
                break;
            case 'annual':
                $dates = [];
                $length = $now->endOfYear()->diffInMonths($now->copy()->startOfYear()) +1;
                $date = $now->startOfYear();

                for ($i = 0; $i < $length; $i++) {
                    $dates[] = $date->copy()->addMonths($i)->format('F');
                    $total[] = Trace::whereBetween('created_at', [
                        $date->copy()->addMonths($i)->startOfMonth()->toDateTimeString(),
                        $date->copy()->addMonths($i)->endOfMonth()->toDateTimeString()
                    ])
                        ->count();
                    $success[] = Trace::where('delivered', 1)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addMonths($i)->startOfMonth()->toDateTimeString(),
                            $date->copy()->addMonths($i)->endOfMonth()->toDateTimeString()
                        ])
                        ->count();
                    $failed[] = Trace::where('delivered', 0)
                        ->where('active', 0)
                        ->whereBetween('created_at', [
                            $date->copy()->addMonths($i)->startOfMonth()->toDateTimeString(),
                            $date->copy()->addMonths($i)->endOfMonth()->toDateTimeString()
                        ])
                        ->count();
                }
                $lengthData = $dates;
                $totalData = $total;
                $successData = $success;
                $failedData = $failed;
                break;
        }

        return response()->json(array($lengthData, $totalData, $successData, $failedData));
    }

    public function traceTableReport(Request $request) {

        $now = Carbon::now();
        $data = null;
        $start = null;
        $end = null;
        switch ($request->input('length')){
            case 'day':
                $data = Trace::with('inventories')->whereBetween('created_at', [
                        $now->copy()->startOfDay()->toDateTimeString(),
                        $now->copy()->endOfDay()->toDateTimeString()
                    ])->get();
                $start = $now->copy()->startOfDay()->toDayDateTimeString();
                $end = $now->copy()->endOfDay()->toDayDateTimeString();
                break;
            case 'week':
                $data = Trace::with('inventories')->whereBetween('created_at', [
                    $now->copy()->startOfWeek()->toDateTimeString(),
                    $now->copy()->endOfWeek()->toDateTimeString()
                ])->get();
                $start = $now->copy()->startOfWeek()->toFormattedDateString();
                $end = $now->copy()->endOfWeek()->toFormattedDateString();
                break;
            case 'month':
                $data = Trace::with('inventories')->whereBetween('created_at', [
                    $now->copy()->startOfMonth()->toDateTimeString(),
                    $now->copy()->endOfMonth()->toDateTimeString()
                ])->get();
                $start = $now->copy()->startOfMonth()->toFormattedDateString();
                $end = $now->copy()->endOfMonth()->toFormattedDateString();
                break;
            case 'range':
                $data = Trace::with('inventories')->whereBetween('created_at', [
                    Carbon::parse($request->input('start'))->toDateTimeString(),
                    Carbon::parse($request->input('end'))->toDateTimeString()
                ])->get();
                $start = Carbon::parse($request->input('start'))->toFormattedDateString();
                $end = Carbon::parse($request->input('end'))->toFormattedDateString();
                break;
        }

        return response()->json(array($data, $start, $end));
    }

    public function printReport(Request $request)
    {
        $datas = $request->input('datas');
        $datas = explode (',', $datas);
//        return $datas;
        return view('layouts.print', compact('datas'));
    }

    public function printReportData(Request $request)
    {
        $datas = $request->input('datas');
        switch ($datas[0]){
            case 'day':
                break;
            case 'week':
                break;
            case 'month':
                break;
            case 'range':
                break;
        }
        return response()->json($datas);
    }

    public function loanReportIndex()
    {
        return view('loan.loan-provider.report.index');
    }

    public function loanReportList(Request $request)
    {
        $data = Loan::with('borrower', 'product', 'provider')
            ->where('status', $request->input('status'))
            ->where('accept', 1)
            ->get();

        return response()->json($data);
    }
}
