<?php

namespace Fwolf\Config;

/**
 * Limit or check app running on server with preferred id
 *
 * @copyright   Copyright 2013-2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class GlobalConfigWithCheckServerId extends GlobalConfig
{
    use CheckServerIdTrait;


    const KEY_SERVER_ID = 'server.id';


    /**
     * @return  string
     */
    public function getServerId()
    {
        return $this->get(static::KEY_SERVER_ID);
    }


    /**
     * @param   string|int $serverId
     * @return  $this
     */
    public function setServerId($serverId)
    {
        $this->set(static::KEY_SERVER_ID, $serverId);

        return $this;
    }
}
