<?php

namespace Fwolf\Config;

use Fwolf\Config\Exception\ServerIdNotSet;
use Fwolf\Config\Exception\ServerIdProhibited;

/**
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait CheckServerIdTrait
{
    /**
     * Get server id from config
     *
     * @return string
     */
    abstract public function getServerId();


    /**
     * Check current server id in allowed list
     *
     * @param   string|int|string[]|int[] $allowedIds
     * @return  bool
     * @throws  ServerIdNotSet
     */
    public function isServerIdAllowed($allowedIds)
    {
        $serverId = $this->getServerId();

        if (empty($serverId)) {
            throw new ServerIdNotSet('Server id not set');
        }

        if (!is_array($allowedIds)) {
            $allowedIds = [$allowedIds];
        }

        return in_array($serverId, $allowedIds);
    }


    /**
     * Limit program can only run on preferred server
     *
     * @param   string|int|string[]|int[] $allowedIds
     * @return  $this
     * @throws  ServerIdProhibited
     */
    public function requireServerId($allowedIds)
    {
        if (!$this->isServerIdAllowed($allowedIds)) {
            $message = 'This program can only run on ' .
                (is_array($allowedIds)
                    ? 'servers: ' . implode(', ', $allowedIds)
                    : 'server ' . $allowedIds);

            throw new ServerIdProhibited($message);
        }

        return $this;
    }
}
