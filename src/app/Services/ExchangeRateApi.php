<?php namespace Davidle90\Payshare\app\Services;

use Exception;
use GuzzleHttp\Client;

class ExchangeRateApi
{
    private $apikey;
    private $base_url;

    public function __construct()
    {
        $this->apikey = config('payshare.exchangerate_api.key');
        $this->base_url = config('payshare.exchangerate_api.url');
    }

    public function convert_currency($from_currency, $to_currency, $amount)
    {
        $client = new Client();
        $url = $this->base_url.$this->apikey.'/pair/'.$from_currency.'/'.$to_currency.'/'.$amount;

        try {

            $response = $client->get($url, [
                'query' => [
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;

        } catch(Exception $e) {
            throw $e;
        }
    }
}
