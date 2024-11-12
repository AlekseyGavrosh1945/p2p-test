<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderTest extends MainTest
{
    /**
     * Тест создания заказа через API
     */
    public function testCreateOrder()
    {
        $client = new Client();

        $data = [
                "currency_code_from" => 'USDT',
                "currency_code_to" => 'RUB',
                "expected_income" => 10,
                "project_name" => 'gavrosh_project',
                "requisite_type" => 'SBP',
        ];

        $items = array_map(fn($i) => "Test Order $i", range(1, 10));

        foreach ($items as $item) {

            $jsonData = json_encode($data);
            $response = $client->post("{$this->apiUrl}/merchant/create_order/?type=api", [
                    'headers' => [
                            'Authorization' => "Token {$this->tokenMerch}",
                            'Content-Type' => 'application/json',
                            'Cookie' => 'csrftoken=fIUkUWjn2C5CoIqymicV4qCcuOWr3igh',
                    ],
                    'body' => $jsonData,
                    'verify' => false,
            ]);

            // Получаем статус ответа
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $this->assertEquals(200, $statusCode, "Ошибка при создании заказа. Статус: {$statusCode}");


            if (!empty($responseBody)) {
                $orderLog = DB::table('core_order')->where('id', $responseBody['id'])->first();

                if ($orderLog) {
                    echo "Номер заказа" . $responseBody['id'] . " создан в таблице -  core_order \n";
                } else {
                    echo "Номер заказа" . $responseBody['id'] . " не создан в таблице -  core_order \n";
                }


                $balanceLog = DB::table('core_balancelog')->where('entity_id', $responseBody['id'])->first();
                if ($balanceLog) {
                    echo "Номер заказа" . $responseBody['id'] . " создан в таблице -  core_balancelog \n";
                } else {
                    echo "Номер заказа" . $responseBody['id'] . " не создан в таблице -  core_balancelog \n";
                }

                $transactionTransactionLog = DB::table('transaction_transaction')->where(
                        'order_id',
                        $responseBody['id']
                )->first();
                if ($transactionTransactionLog) {
                    echo "Номер заказа" . $responseBody['id'] . " создан в таблице -  transaction_transaction \n";
                } else {
                    echo "Номер заказа" . $responseBody['id'] . " не создан в таблице -  transaction_transaction \n";
                }

                $transactionLog = DB::table('transaction_orderstatushistory')->where(
                        'order_withdrawal_uuid',
                        $responseBody['id']
                )->first();
                if ($transactionLog) {
                    echo "Номер заказа" . $responseBody['id'] . " создан в таблице -  transaction_orderstatushistory \n";
                } else {
                    echo "Номер заказа" . $responseBody['id'] . " не создан в таблице -  transaction_orderstatushistory \n";
                }
            } else {
                echo "Заказ не создан \n";
            }
        }


//        Promise\Utils::settle($promises)->wait();


//        // Проверка получения данных из ответа
//        $accountNumber = $responseBody['requisite']['account_number'] ?? null;
//        $expectedIncome = $responseBody['expected_income'] ?? null;
//
//        $this->assertNotNull($accountNumber, 'Account number не найден в ответе.');
//        $this->assertNotNull($expectedIncome, 'Expected income не найден в ответе.');
//
//        // Получение последних 4 цифр account_number
//        $last4Digits = substr($accountNumber, -4);
//
//        // Формируем текст для второго запроса (SMS)
//        $smsText = "VISA{$last4Digits} 17:52 Перевод {$expectedIncome}р от Артём Ц. Баланс: 633.27р";
//
//        // Выполнение второго запроса (отправка SMS)
//        $smsResponse = $client->post("{$this->apiUrl}/sms_messages/send_message/" . env('DEVICE_NUMBER'), [
//                'headers' => [
//                        'Content-Type' => 'application/json',
//                ],
//                'json' => [
//                        'sender' => '900',
//                        'text' => $smsText,
//                        'message_type' => 'SMS',
//                ],
//                'verify' => false, // Отключение проверки SSL (если нужно)
//        ]);
//
//        // Логируем ответ от SMS отправки
//        Log::info("SMS Response: ", json_decode($smsResponse->getBody()->getContents(), true));
//
//        // Проверяем статус отправки SMS
//        $this->assertEquals(200, $smsResponse->getStatusCode(), 'Ошибка при отправке SMS.');
    }
}