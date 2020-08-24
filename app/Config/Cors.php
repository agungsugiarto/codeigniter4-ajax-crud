<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public $allowedHeaders = ['*'];

    public $allowedMethods = ['*'];

    public $allowedOrigins = ['*'];

    public $exposedHeaders = [];

    public $maxAge = 0;

    public $supportsCredentials = false;
}
