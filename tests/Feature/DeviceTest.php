<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class DeviceTest extends MainTest
{
    /**
     * Тестирование создания устройств
     *
     * @return void
     */
    public function testDeviceCreation()
    {
        $client = new Client();
        $response = $client->get("{$this->apiUrl}/devices/", [
                'headers' => [
                        'Authorization' => "Token {$this->tokenTrader}",
                        'Content-Type' => 'application/json',
                ],
                'verify' => false,
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        \Illuminate\Support\Facades\Log::info(print_r("testDeviceCreation = " . date("Y-m-d H:i:s"), true));
        \Illuminate\Support\Facades\Log::info(print_r($responseBody, true));

        if (!empty($responseBody)) {
            $count = $responseBody['count'];
            $deviceTraderCount = 0;
            foreach ($responseBody['results'] as $trader) {
                $deviceTraderCount = DB::table('devices_device')->where('trader_id', $trader['trader'])->count();
                break;
            }

            if ($deviceTraderCount != $count) {
                echo "Количество девайсов у Трейдера не соответствует пришедшим значениям по API. \n";
            } else {
                echo "Количество девайсов у Трейдера соответствует пришедшим значениюям по API. \n";
            }
            echo "Количество девайсов у Трейдера по API " . $count . " \n";
            echo "Количество девайсов у Трейдера в БД " . $deviceTraderCount . " \n";
        }
        echo "testDeviceCreation: " . "\n";
    }
}
