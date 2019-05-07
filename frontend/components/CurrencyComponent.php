<?php
namespace frontend\components;

use GuzzleHttp\Client;
use yii\base\BaseObject;
use yii\base\Component;
use yii\helpers\Json;

class CurrencyComponent extends Component
{
    private $apiKey = '00c4475613356ac034e67fa65c9cc8e1';

    public $currencyArray;

    private $url = 'http://api.coinlayer.com/';

    protected  $client;

    public function init()
    {

        $this->client = new Client();
    }

    public function getCurrencies()
    {
        $url = $this->url.'live?access_key='.$this->apiKey;
        if (!empty($this->currencyArray)){
            $url .= '&symbols='.implode(',', $this->currencyArray);
        }
        $data = $this->sendData($url);
        return $data['rates'];
    }

    public function getChangeRates(string $from, string $to, int $amount)
    {
        $url = $this->url.'convert?access_key='.$this->apiKey.'&from='.$from.'&to='.$to.'&amount='.$amount;
        $data = $this->sendData($url);
        return $data['result'];
    }

    protected function sendData($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        return Json::decode($json);

    }
}