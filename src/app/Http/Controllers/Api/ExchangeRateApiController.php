<?php namespace Davidle90\Payshare\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Http\Services\ExchangeRateApi;
use Illuminate\Http\Request;

class ExchangeRateApiController extends Controller
{
    protected $exchangeRateApi;

    public function __construct(ExchangeRateApi $exchangeRateApi)
    {
        $this->exchangeRateApi = $exchangeRateApi;
    }

    public function convert(Request $request)
    {
        $input = [
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'amount' => $request->input('amount')
        ];

        $data = $this->exchangeRateApi->convert_currency($input['from'], $input['to'], $input['amount']);

        if($data['result'] == 'success'){
            $response = [
                'status' => 1,
                'conversion_rate' => $data['conversion_rate'],
                'conversion_result' => $data['conversion_result']
            ];
        }

        return response()->json($response);
    }
}