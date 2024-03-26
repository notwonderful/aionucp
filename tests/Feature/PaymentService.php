<?php

use App\Http\Controllers\DonateController;
use App\Http\Requests\DonateRequest;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use App\Services\Payments\Gateways\PalychGateway;
use App\Services\Payments\PaymentService;

test('payment service creates a new donation record and processes the payment', function () {
    $paymentGateway = mock(PaymentGatewayContract::class);
    $paymentGateway->shouldReceive('processPayment')
        ->once()
        ->andReturn(redirect('/payment-success'));

    $paymentService = new PaymentService();

    $response = $paymentService->createPayment(
        amount: 666,
        currency: 'USD',
        paymentSystem: 'palych',
        userId: 1,
        paymentGateway: $paymentGateway
    );

    $this->assertDatabaseHas('donates', [
        'amount' => 666,
        'currency' => 'USD',
        'payment_system' => 'palych',
        'user_id' => 1,
    ]);

    $this->assertTrue($response->isRedirect());
    $this->assertEquals('/payment-success', $response->getTargetUrl());
});

test('donate controller selects the correct payment gateway', function () {
    $palychGateway = mock(PalychGateway::class);
    $palychGateway->shouldReceive('processPayment')
        ->once()
        ->andReturn(redirect('/palych-payment-success'));

    $anotherGateway = mock(PaymentGatewayContract::class);
    $anotherGateway->shouldReceive('processPayment')
        ->once()
        ->andReturn(redirect('/another-payment-success'));

    $controller = new DonateController();

    $palychRequest = mock(DonateRequest::class);
    $palychRequest->shouldReceive('validated')
        ->andReturn([
            'amount' => 666,
            'currency' => 'USD',
            'payment_system' => 'palych',
        ]);

    $response = $controller->store($palychRequest);

    $this->assertTrue($response->isRedirect());
    $this->assertEquals('/palych-payment-success', $response->getTargetUrl());

    $anotherRequest = mock(DonateRequest::class);
    $anotherRequest->shouldReceive('validated')
        ->andReturn([
            'amount' => 666,
            'currency' => 'USD',
            'payment_system' => 'another_gateway',
        ]);

    $response = $controller->store($anotherRequest);

    $this->assertTrue($response->isRedirect());
    $this->assertEquals('/another-payment-success', $response->getTargetUrl());
});
