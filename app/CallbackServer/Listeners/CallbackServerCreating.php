<?php

namespace App\CallbackServer\Listeners;

use App\Projects\Events\ProjectCreated;
use App\CallbackServer\Repositories\CallbackServerRepository;
use App\Core\Facades\DBHelper;
use App\Core\Facades\UniqueRandomString;
use App\CallbackServer\Models\CallbackServer;

class CallbackServerCreating
{
    /**
     * @var CallbackServerRepository
     */
    private CallbackServerRepository $callbackServerRepository;

    public function __construct(CallbackServerRepository $callbackServerRepository)
    {
        $this->callbackServerRepository = $callbackServerRepository;
    }


    public function handle(ProjectCreated $event): void
    {
        $callbackServer = DBHelper::transactionOrFail(function () use ($event) {
            $callbackServer = $this->callbackServerRepository->create([
                 'projectId' => $event->project->id,
                 'code' => UniqueRandomString::uniqueRandom((new CallbackServer())->getTable(), 'code', 8),
                 // TODO Use eloquent type casts
                 'data' => json_encode(array()),
             ]);
             return $callbackServer;
        });
    }
}
