<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class RequisiteTest extends MainTest
{
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function testRequisiteTrader()
//    {
//        $client = new Client();
//        $response = $client->get("{$this->apiUrl}/requisite/", [
//                'headers' => [
//                        'Authorization' => "Token {$this->tokenTrader}",
//                        'Content-Type' => 'application/json',
//                ],
//                'verify' => false,
//        ]);
//
//        $responseBody = json_decode($response->getBody()->getContents(), true);
//        \Illuminate\Support\Facades\Log::info(print_r("testRequisiteTrader = " . date("Y-m-d H:i:s"), true));
////        \Illuminate\Support\Facades\Log::info(print_r($responseBody, true));
//
//        if (!empty($responseBody)) {
//            $count = $responseBody['count'];
//
//            $countRequisite = DB::table('core_requisite as cr')
//                    ->join('core_user as cu', 'cr.trader_id', '=', 'cu.id')
//                    ->where('cu.username', $this->usernameTrader)->count();
//
//            if (!empty($responseBody)) {
//                if ($countRequisite != $count) {
//                    echo "Количество реквизитов у Трейдера не соответствует пришедшим значениям по API. \n";
//                } else {
//                    echo "Количество реквизитов у Трейдера соответствует пришедшим значениюям по API. \n";
//                }
//                echo "Количество реквизитов у Трейдера по API " . $count . " \n";
//                echo "Количество реквизитов у Трейдера в БД " . $countRequisite . " \n";
//            } else {
//                echo "ТРЕЙДЕР с username  = " . $this->usernameTrader. " не найден  \n";
//            }
//        } else {
//            echo "Реквизиты не найдены : " . "\n";
//        }
//
//        echo "testRequisiteTrader: " . "\n";
//    }
}
