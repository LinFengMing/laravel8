<?php

namespace App\Http\Services;

class TryService
{
    public $shortUrlService;

    public function __construct(ShortUrlInterfaceService $service)
    {
        $this->shortUrlService = $service;
    }

    public function callTry()
    {
        $service = app()->make('ShortUrlService');
        dd($service->version);
    }

    public $name = 'jiro';

    public function __set($name, $value)
    {
        if(isset($this->name)) {
            return $this->name = $value;
        }
        else {
            return null;
        }
    }

    public function __get($name)
    {
        return $name;
    }

    public function __call($method, $arges)
    {
        dump('一般方法');
        dump($method);
        dump($arges);
    }
}
