<?php

namespace App\CallbackServer\Listeners;

use App\CallbackServer\Events\CallbackServerConfirmationEvent;
use App\CallbackServer\Repositories\CallbackServerRepository;
use App\Core\Facades\DBHelper;
use Illuminate\Support\Facades\Log;

class CallbackServerConfirmation
{
    /**
     * @var CallbackServerRepository
     */
    private CallbackServerRepository $callbackServerRepository;

    public function __construct(CallbackServerRepository $callbackServerRepository)
    {
        $this->callbackServerRepository = $callbackServerRepository;
        // TODO why is it here ?
        $this->callbackServerRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }


    public function handle(CallbackServerConfirmationEvent $event): void
    {
        echo $event->callbackServer->data['vk']['confirmationCode'];
        $callbackServerConfirmation = DBHelper::transactionOrFail(function () use ($event) {
            $data = $event->callbackServer->data;
            $data['vk']['confirmed'] = 1;
            $event->callbackServer->data = $data;
            $updateWithCode = $this->callbackServerRepository->update( ['data' =>  $event->callbackServer->data], $event->callbackServer->id );
            return $updateWithCode;
        });
    }
}
