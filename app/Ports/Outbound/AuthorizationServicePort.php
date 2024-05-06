<?php

namespace App\Ports\Outbound;

interface AuthorizationServicePort
{
    public function authorize(): void;
}
