<?php

namespace App\Traits;

use CodeIgniter\Config\Config;
use Hashids\Hashids;

trait HashableTrait
{
    /**
     * Decode hash.
     *
     * @param string|int $hash
     *
     * @return mixed
     */
    public function decodeHash($hash = '')
    {
        if (empty($hash)) {
            throw new \Exception('Invalid hashed id.');
        }

        return static::hashids()->decode($hash)[0];
    }

    /**
     * Enocode hash.
     *
     * @param string $hash
     *
     * @return mixed
     */
    public function encodeHash($hash = '')
    {
        if (empty($hash)) {
            throw new \Exception('Invalid hashed id.');
        }

        return static::hashids()->encode($hash);
    }

    /**
     * Instance class Hashids.
     */
    protected static function hashids()
    {
        return new Hashids(Config::get('Encryption')->key, 32);
    }
}
