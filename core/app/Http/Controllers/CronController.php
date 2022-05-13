<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CronController extends Controller
{
    

    public function index()
    {
        $general = GeneralSetting::first();
        $general->last_cron_run = Carbon::now();
        $general->save();
        $url = 'https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=USD&api_key='. $general->coin_rate_api;
        $crypto = file_get_contents($url);
        $usd = json_decode($crypto, true);
        dd($usd);
        $cryptoRate = $usd['USD'];
        $general->btc_price = $cryptoRate;
        $general->save();
        return 0;
    }
}
