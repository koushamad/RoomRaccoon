<?php

namespace Kousha\RoomRaccoon\Core;

use Pimple\Container;

class Controller {
    protected Container $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
}