<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public static function getRates(string $code)
    {
        $url = 'https://www.cbr-xml-daily.ru/daily_json.js';
        $data = Http::get($url);
        $rates = json_decode($data->body())->Valute;

        return round($rates->{$code}->Value, 2);

//        return [
//            'today' =>  round($rates->{$code}->Value,2),
//            'yesterday' =>  round($rates->{$code}->Previous,2),
//            'ratio' =>  $rates->{$code}->Nominal
//        ];
    }

    public function updateRates()
    {
        $currencies = Currency::all();
        $i = 0;
        foreach ($currencies as $currency) {
            $currency->update(['amount' => self::getRates($currency->code)]);
            $i++;
        }
        return true;
    }

    public function calc(string $fromCode, string $toCode, float $amount): float
    {
        $from = Currency::where('code', $fromCode)->first();
        $to = Currency::where('code', $toCode)->first();

        return round($amount * ($from->amount / $to->amount), 2);
    }

    public function convert(ConvertRequest $request)
    {
//        dd($request->all());
        $result = $this->calc($request->fromCode, $request->toCode, (float)$request->amount);
        return view('welcome')->with([
            'resultSymbol' => self::getSymbol($request->toCode),
            'resultAmount' => $result,
            'curList' => self::getCurList(),
            'fromSymbol' => self::getSymbol($request->fromCode),
            'rateAmount' => self::getRate($request->fromCode, $request->toCode),
            'amount' => (float)$request->amount
        ]);
    }

    public static function getSymbol(string $code): string
    {
        $symbol = [
            'RUR' => '₽',
            'USD' => '$',
            'EUR' => '€'
        ];
        return $symbol[$code];
    }


    public function welcome()
    {
        return view('welcome')->with([
            'resultAmount' => null,
            'curList' => self::getCurList()
        ]);
    }

    public static function getCurList(): array
    {
        return Currency::all()->pluck('code', 'code')->toArray();
    }

    public static function getRate(string $fromCode, string $toCode): float
    {
        $data = self::getCurrenciesData($fromCode, $toCode);
        return round($data['from']['amount'] / $data['to']['amount'], 4);
    }

    /**
     * Метод
     * @param string $fromCode
     * @param string $toCode
     * @return array
     */
    public static function getCurrenciesData(string $fromCode, string $toCode) :array
    {
        return [
            'from' => Currency::where('code', $fromCode)->first()->toArray(),
            'to' => Currency::where('code', $toCode)->first()->toArray(),
        ];
    }
}
