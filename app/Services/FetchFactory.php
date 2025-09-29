<?php

namespace App\Services;

class FetchFactory
{
    protected static array $providers = [
        'OpenAPI'  => OpenApi::class,
        'Guardian' => Guardian::class,
        'BBC'=>BBC::class,
    ];

    public static function getProviders(string $provider):DataFetchingInterface
    {
        if(!array_key_exists($provider, self::$providers)) {
            throw new \Exception("Provider '{$provider}' not exist");
        }
        return app()->make(self::$providers[$provider],['provider' => $provider]);
    }
}
