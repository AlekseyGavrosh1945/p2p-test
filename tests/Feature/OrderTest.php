<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {

    }
}

//
//namespace Tests\Feature;
//
//use GuzzleHttp\Client;
//use GuzzleHttp\Promise;
//use Tests\TestCase;
//
//class DeviceTest extends TestCase
//{
//    // Токен и URL-адрес API
////    private string $apiUrl = 'http://localhost:8001/api/v1';
//    private string $apiUrl = 'https://dev-backend.p2p-dev.maxbit.private/api/v1';
//    private string $token = 'ff61cc0299feae7dd3eedfe3b80ab426c6c034de';
//
//    /**
//     * Тестирование параллельного создания устройств
//     *
//     * @return void
//     */
//    public function testParallelDeviceCreation()
//    {
//        $client = new Client();
//        $deviceNames = array_map(fn($i) => "Test Device $i", range(1, 10));
//        $promises = [];
//
//
//        $data = request()->all();
//        \Illuminate\Support\Facades\Log::info(print_r("11111111111 = "  .  date("Y-m-d H:i:s"),  true));
//        \Illuminate\Support\Facades\Log::info(print_r($data, true));
//        \Illuminate\Support\Facades\Log::info(print_r($deviceNames, true));
//
//        foreach ($deviceNames as $deviceName) {
//
//
//            $promises[] = $client->getAsync("{$this->apiUrl}/devices", [
//                    'headers' => [
//                            'Authorization' => "Token {$this->token}",
//                            'Content-Type' => 'application/json',
//                    ]
//            ])->then(
//                    function ($response) use ($deviceName) {
//
//                        echo ' check';
//
//                        // Проверка статуса ответа
//                        $this->assertEquals(201, $response->getStatusCode(), "Failed for device: $deviceName");
//
//                        // Вывод информации о результате для каждого устройства
//                        $responseBody = json_decode($response->getBody()->getContents(), true);
//                        echo "Device: $deviceName, Response: " . json_encode($responseBody) . "\n";
//                    },
//                    function ($exception) {
//                        $this->fail("Request failed: " . $exception->getMessage());
//                    }
//            );
//
//            exit();
//        }
//
//        echo ' FINISH';
//
//        // Выполняем все запросы параллельно
//        Promise\Utils::settle($promises)->wait();
//    }
//}
