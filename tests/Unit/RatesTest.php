<?php

namespace Tests\Feature;

use App\Http\Controllers\CurrencyController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatesTest extends TestCase
{
    public function test_get_rates()
    {
        $curr = new CurrencyController();
        $do = $curr->getRates('EUR');
        dump($do);
        $this->assertTrue(true);
    }

    public function test_update_rates()
    {
        $curr = new CurrencyController();
        $do = $curr->updateRates();
        dump($do);
        $this->assertTrue(true);
    }
}
