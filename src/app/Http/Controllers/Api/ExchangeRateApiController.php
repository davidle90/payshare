<?php namespace Davidle90\Payshare\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Services\ExchangeRateApi;
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
            'from' => $request->get('from_currency'),
            'to' => $request->get('to_currency'),
            'amount' => $request->get('amount')
        ];

        if(isset($input['amount'])){
            $data = $this->exchangeRateApi->convert_currency($input['from'], $input['to'], $input['amount']);

            if($data['result'] == 'success'){
                $response = [
                    'status' => 1,
                    'conversion_rate' => $data['conversion_rate'],
                    'conversion_result' => $data['conversion_result'],
                    'currency' => $input['to']
                ];
            }
        } else {
            $response = [
                'status' => 0,
                'error_message' => 'Error: Input field missing.',
            ];
        }

        

        return response()->json($response);
    }
}
