<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    /**
     * Экшен
     * @param ConvertRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * Отображение путой формы
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function welcome()
    {
        return view('welcome')->with([
            'resultAmount' => null,
            'curList' => self::getCurList()
        ]);
    }

    /**
     * Получение актуального курса по ISO коду валюты
     * @param string $code
     * @return float
     */
    public static function getRates(string $code)
    {
        $url = 'https://www.cbr-xml-daily.ru/daily_json.js';
        $data = Http::get($url);
        $rates = json_decode($data->body())->Valute;

        return round($rates->{$code}->Value, 2);
    }

    /**
     * Обновление курсов валют (задел на будущее)
     * @return bool
     */
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

    /**
     * Метод конвертации
     * @param string $fromCode
     * @param string $toCode
     * @param float $amount
     * @return float
     */
    public function calc(string $fromCode, string $toCode, float $amount): float
    {
        $data = self::getCurrenciesData($fromCode, $toCode);
        return round($amount * ($data['from']['amount'] / $data['to']['amount']), 2);
    }

    /**
     * Символы валюты по коду
     * @param string $code
     * @return string
     */
    public static function getSymbol(string $code): string
    {
        $symbol = [
            'RUR' => '₽',
            'USD' => '$',
            'EUR' => '€'
        ];
        return $symbol[$code];
    }

    /**
     * Список кодов валют в базе
     * @return array
     */
    public static function getCurList(): array
    {
        return Currency::all()->pluck('code', 'code')->toArray();
    }

    /**
     * Получение курса валюты конвертации
     * @param string $fromCode
     * @param string $toCode
     * @return float
     */
    public static function getRate(string $fromCode, string $toCode): float
    {
        $data = self::getCurrenciesData($fromCode, $toCode);
        return round($data['from']['amount'] / $data['to']['amount'], 4);
    }

    /**
     * Метод получение данных валют из базы
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
