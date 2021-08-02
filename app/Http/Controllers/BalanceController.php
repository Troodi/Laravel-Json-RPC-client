<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BalanceController extends Controller
{
    /*
     * Метод делает JSON-RPC запросы и получает баланс пользователя и историю операций
     * Возвращает view с балансом и историей
     */
    public function getUserBalance(){
        $getBalanceJson = '{"jsonrpc": "2.0", "method": "balance.userBalance", "params": {"user_id": 10}, "id": 1}';
        $client = new Client(["base_uri" => "http://balance.me"]);
        $result = $client->post('/api/data', ["body" => $getBalanceJson]);
        $balance = json_decode($result->getBody()->getContents())?->result;
        $getBalanceHistoryJson = '{"jsonrpc": "2.0", "method": "balance.history", "params": {"limit": 50}, "id": 2}';
        $result = $client->post('/api/data', ["body" => $getBalanceHistoryJson]);
        $history = json_decode($result->getBody()->getContents())?->result;
        return view('welcome', compact('balance', 'history'));
    }
}
