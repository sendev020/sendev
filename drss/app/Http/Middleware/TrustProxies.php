<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Les proxies de confiance. Mettre '*' pour accepter tous les proxies.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * En-têtes utilisés pour détecter les proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
