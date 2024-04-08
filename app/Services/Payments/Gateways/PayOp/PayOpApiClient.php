<?php

namespace App\Services\Payments\Gateways\PayOp;

use App\Supports\Helpers\CurrencyHelper;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use stdClass;

final readonly class PayOpApiClient
{
    public const STATUS_WAIT = 'wait';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';
    public const LANG_EN = 'en';
    public const LANG_RU = 'ru';
    public function __construct(
        private string $publicKey,
        private string $secretKey,
        private string $lang,
        protected string $apiUrl = 'https://payop.com/'
    ) {}

    public function createPayment(array $params): false|string
    {
        $this->checkRequiredParams(['order.id', 'order.amount', 'order.currency', 'order.items', 'payer.email'], $params);
        $params['order']['currency'] = CurrencyHelper::toString($params['order']['currency']);
        $params = $this->signParams($params);

        $response = $this->dispatch($params);

        if ($response->ok()) {
            return sprintf(
                'https://checkout.payop.com/en/payment/%s',
                $response->header('identifier')
            );
        }

        logger()->debug('PayOp API error', ['response' => $response->json()]);

        return false;
    }

    private function dispatch(array $params): Response
    {
        $params['language'] = $this->lang;
        return Http::asJson()
            ->post(
                $this->apiUrl . 'v1/invoices/create',
                $params
            );
    }

    private function signParams(array $params): array
    {
        $params['secretKey'] = $this->secretKey;
        $params['publicKey'] = $this->publicKey;
        $params['signature'] = $this->generateSignature($params['order']);
        return $params;
    }

    private function checkRequiredParams(array $keys, array $data): void
    {
        $default = new stdClass;
        foreach ($keys as $key){
            $value = data_get($data, $key, $default);
            if ($value === $default) {
                throw new \InvalidArgumentException($key . ' is null');
            }
        }
    }

    public function generateSignature(array $order, ?string $status = null): string
    {
        $this->checkRequiredParams(['id', 'amount', 'currency'], $order);

        unset($order['items'], $order['description']);
        ksort($order, SORT_STRING);

        $dataSet = array_values($order);
        if ($status) {
            $dataSet[] = $status;
        }
        $dataSet[] = $this->secretKey;

        return hash('sha256', implode(':', $dataSet));
    }

    public function paymentHandler(): array
    {
        $response = json_decode(request()->getContent(), true);
        logger()->debug('payop', ['input' => $response]);

        if (empty($response) || $response['signature'] !== $this->generateSignature($response, $response['status'])) {
            throw new InvalidArgumentException('Response empty or wrong signature');
        }

        return $response;
    }
}
