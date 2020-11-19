<?php

namespace Tests\Feature;

use App\Http\Controllers\CurrencyController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogicTest extends TestCase
{
    public function test_calc()
    {
        $c = new CurrencyController();
        $do = $c->calc('EUR', 'USD', 10);
        dump($do);
        $this->assertTrue(true);
    }

    public function test_getSymbol()
    {
        $do = CurrencyController::getSymbol('RUR');
        dump($do);
        $this->assertIsString($do);
    }

    public function test_getFromToData()
    {
        $do = CurrencyController::getCurrenciesData('RUR','USD');
        dump($do);
        $this->assertIsArray($do);
    }

    public function test_GetList()
    {
        $do = CurrencyController::getCurList();
        dump($do);
        $this->assertIsArray($do);
    }

    public function test_getRate()
    {
        $do = CurrencyController::getRate('USD','RUR');
        dump($do);
        $this->assertIsFloat($do);
    }
}
