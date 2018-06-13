<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'hl7/checkin','hl7/checkout','hl7/acceptMessage','hl7/responder', 'hl7/marcarEnviada'
    ];
}
