<?php

namespace App\Http\Controllers;
use App\Services\JsonRpcClient;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BalanceController extends Controller
{
    protected $client;

    public function __construct(JsonRpcClient $client)
    {
        $this->client = $client;
    }


    /*
     * Метод делает JSON-RPC запросы и получает баланс пользователя и историю операций
     * Возвращает view с балансом и историей
     */
    public function getUserBalance(){
        $data = $this->client->send('balance.userBalance', ['user_id' => 10]);
        $balance = $data['result'];
        $data = $this->client->send('balance.history', ['limit' => 50]);
        $history = $data['result'];
        return view('welcome', compact('balance', 'history'));
    }
}
