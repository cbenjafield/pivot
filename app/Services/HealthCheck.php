<?php

namespace App\Services;

class HealthCheck
{
    protected $curl;
    
    public function __construct(string $url)
    {
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => 'PivotBot-HealthCheck/1.0',
            CURLOPT_URL => $url,
        ]);
    }

    public function check()
    {
        $result = curl_exec($this->curl);
        $info = curl_getinfo($this->curl);
        curl_close($this->curl);

        return (object) [
            'body' => $result,
            'info' => $info,
            'status' => $info['http_code'],
        ];
    }
}