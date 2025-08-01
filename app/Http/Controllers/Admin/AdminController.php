<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function respondentsChart()
    {
        $items = DB::table('respondents')
            ->select([
                DB::raw('date(created_at) as date'),
                DB::raw('count(1) as c')
            ])
            ->groupByRaw('date(created_at)')
            ->get()
            ->keyBy('date')
            ->toArray();

        $label = [];
        $data = [];
        for ($i = 59; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $count = $items[$date]->c ?? 0;
            $data[] = $count;
            $label[] = Verta::instance($date)->format('Y/m/d');
        }

        return compact('label', 'data');
    }

    public function dashboard()
    {
        $respondents = $this->respondentsChart();

        return view('admin.dashboard', compact('respondents'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
