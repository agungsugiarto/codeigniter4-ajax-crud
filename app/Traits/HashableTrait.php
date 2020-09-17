<?php

namespace App\Traits;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Config\Config;
use CodeIgniter\Exceptions\PageNotFoundException;
use Hashids\Hashids;

trait HashableTrait
{
    use ResponseTrait;

    /**
     * Decode hash.
     *
     * @param string|int $hash
     *
     * @return mixed
     */
    public function decodeHash(string $hash)
    {
        try {
            $decoce = static::hashids()->decode($hash);
        } catch (\Exception $e) {
            return PageNotFoundException::forMethodNotFound($e->getMessage());
        }

        return $decoce[0];
    }

    /**
     * Enocode hash.
     *
     * @param string $hash
     *
     * @return mixed
     */
    public function encodeHash(string $hash)
    {
        try {
            $encode = static::hashids()->encode($hash);
        } catch (\Exception $e) {
            return PageNotFoundException::forMethodNotFound($e->getMessage());
        }

        return $encode;
    }

    /**
     * Instance class Hashids.
     */
    protected static function hashids()
    {
        return new Hashids(Config::get('Encryption')->key, 32);
    }
}
