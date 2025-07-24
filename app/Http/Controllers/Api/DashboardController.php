<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Song;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $usersPerMonth = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                ->where('role', '!=', 'admin')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        $songsPerMonth = Song::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                ->groupBy(['month', 'origin_name'])
                ->orderBy('month')
                ->get();
        $usersPerMonthData = [];
        $artistCount = 0; $musicUserCount = 0;
        foreach ($usersPerMonth as $key => $month) {
            $date = Carbon::createFromFormat('!m', $month->month);
            $usersPerMonthData[$key]['month'] = $date->format('F');
            $usersPerMonthData[$key]['artist'] = $month->count;
            $artistCount +=  $month->count;
            $usersPerMonthData[$key]['songs'] = 0;
            $musicUserCount += 10;
        }

        // foreach ($songsPerMonth as $key => $month) {
        //     $date = Carbon::createFromFormat('!m', $month->month);
        //     $usersPerMonthData[$key]['month'] = $date->format('F');
        //     $usersPerMonthData[$key]['songs'] = $month->count;
        // }

        // foreach ($usersPerMonthData as $key => $value) {
        //     $date = Carbon::createFromFormat('!m', $value->month);
        //     $usersPerMonthData['month'][$date->format('F')]['songs'] = $value->count;
        // }
        return response()->json([
            'status' => 'success',
            'result' => [
                'totals' => array(
                    'artist' => User::all()->count() - 1,
                    'songs' => Song::all()->count(),
                    'musicUser' => 0,
                    'other' => 0,
                ),
                'registeredUsers' => $usersPerMonthData,
                'progress' => [
                    'artistCount' => ( $artistCount/($artistCount + $musicUserCount) ) * 100,
                    'musicUserCount' => 0,
                ],
                'recentUsers' => User::without(['bank', 'emergency', 'heir', 'artist'])->latest()->limit(5)->get(),
            ]
        ]);
    }
}
