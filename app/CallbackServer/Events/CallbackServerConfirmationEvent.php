<?php

namespace App\CallbackServer\Events;

use App\CallbackServer\Models\CallbackServer;

class CallbackServerConfirmationEvent
{
    /**
     * @var CallbackServer
     */
    public CallbackServer $callbackServer;

    public function __construct($callbackServer)
    {
        $this->callbackServer = $callbackServer;
    }
}
