<?php

namespace Razorpay\Tests;

require_once realpath(__DIR__.'/../vendor/autoload.php');

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase as PhpUnitTest;
use Razorpay\Api\Api;

if (class_exists('Dotenv')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

class TestCase extends PhpUnitTest
{
    public function setUp(): void
    {
        $apiKey = getenv('RAZORPAY_API_KEY') ? getenv('RAZORPAY_API_KEY') : '';
        $apiSecret = getenv('RAZORPAY_API_SECRET') ? getenv('RAZORPAY_API_SECRET') : '';

        $this->api = new Api($apiKey, $apiSecret);
    }
}
