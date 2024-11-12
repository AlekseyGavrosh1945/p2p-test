<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class MainTest extends TestCase
{
    /**
     * @var
     */
    protected mixed $apiUrl;
    protected mixed $traderId;
    protected mixed $usernameMerch;
    protected mixed $usernameTrader;
    protected string $tokenMerch;
    protected string $tokenTrader;

    /**
     * Конструктор для получения токена
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->apiUrl = env('API_URL');
        $this->traderId = env('TRADER_ID');
        $this->usernameMerch = env('USERNAME_MERCH');
        $this->usernameTrader = env('USERNAME_TRADER');
        $this->tokenMerch = $this->getToken($this->usernameMerch, env('PASSWORD_MERCH'));
        $this->tokenTrader = $this->getToken($this->usernameTrader, env('PASSWORD_TRADER'));

        \Illuminate\Support\Facades\Log::info(print_r("MainTest = " . date("Y-m-d H:i:s"), true));
        \Illuminate\Support\Facades\Log::info(print_r("tokenMerch - " .  $this->tokenMerch, true));
        \Illuminate\Support\Facades\Log::info(print_r("tokenTrader - " .  $this->tokenTrader, true));
    }

    /**
     * Получение токена для пользователя
     *
     * @param  string  $username
     * @param  string  $password
     * @param  string  $userType
     * @return string $authToken
     * @throws \Exception
     */
    private function getToken(string $username, string $password)
    {
        $url = $this->apiUrl . '/auth/token/login/';


        $data = [
                'username' => $username,
                'password' => $password
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);

        // Обработка ошибок cURL
        if ($response === false) {
            Log::error('cURL error: ' . curl_error($ch));
            curl_close($ch);
            throw new \Exception("Ошибка при выполнении запроса к API: " . curl_error($ch));
        }

        curl_close($ch);
        $responseArray = json_decode($response, true);

        if (isset($responseArray['auth_token'])) {
            return $responseArray['auth_token'];
        } else {
            // Если токен не получен, выводим ошибку
            throw new \Exception("Ошибка: Токен не получен.");
        }
    }
}
