<?php

namespace Cellular\Config;

use Config\Services as BaseServices;

class Services extends BaseServices
{
    /**
     * Returns the Cellular instance.
     */
    public static function cellular($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cellular');
        }

        return new \Cellular\Cellular(BaseServices::cache());
    }
}
