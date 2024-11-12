<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BalanceTest extends MainTest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBalanceTrader()
    {
        $client = new Client();
        $response = $client->get("{$this->apiUrl}/users/get_balance/", [
                'headers' => [
                        'Authorization' => "Token {$this->tokenTrader}",
                        'Content-Type' => 'application/json',
                ],
                'verify' => false,
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        if (!empty($responseBody)) {
            $balance = $responseBody['balance'];
            $balance_outcome = $responseBody['balance_outcome'];
            $frozen_balance = $responseBody['frozen_balance'];
            $total_income = $responseBody['total_income'];

            $trader = DB::table('core_trader as ct')
                    ->join('core_user as cu', 'ct.user_ptr_id', '=', 'cu.id')
                    ->where('cu.username', $this->usernameTrader)->first();


            if (!empty($trader)) {
                if ($trader->balance != $balance ||
                        $trader->balance_outcome != $balance_outcome ||
                        $trader->frozen_balance != $frozen_balance ||
                        $trader->total_income != $total_income
                ) {
                    echo "Данные по балансу у Трейдера не соответствует пришедшим данным по API . \n";
                } else {
                    echo "Данные по балансу у Трейдера соответствует пришедшим данным по API . \n";
                }

                echo "balance в БД = " . $trader->balance . "   баланс по API = " . $balance . "\n";
                echo "balance_outcome в БД = " . $trader->balance_outcome . "   баланс по API = " . $balance_outcome . "\n";
                echo "frozen_balance в БД = " . $trader->frozen_balance . "   баланс по API = " . $frozen_balance . "\n";
                echo "total_income в БД = " . $trader->total_income . "   баланс по API = " . $total_income . "\n";
            } else {
                echo "ТРЕЙДЕР с username  = " . $this->usernameTrader. " не найден  \n";
            }
        }
        echo "testBalanceTrader: " . "\n";
    }
}
