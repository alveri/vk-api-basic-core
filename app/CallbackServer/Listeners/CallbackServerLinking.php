<?php

namespace App\CallbackServer\Listeners;

use App\Tokens\Events\TokenCreated;
use App\CallbackServer\Repositories\CallbackServerRepository;
use App\CallbackServer\Exceptions\CallbackServerException;
use App\Core\Facades\DBHelper;
use App\Common\VKConstants;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Session;
use URL;
use VK\Client\VKApiClient;


class CallbackServerLinking
{

    /**
     * @var CallbackServerRepository
     */
    private CallbackServerRepository $callbackServerRepository;

    /**
     * @var VKApiClient
     */
    private VKApiClient $vkApiClient;

    public function __construct(CallbackServerRepository $callbackServerRepository, VKApiClient $vkApiClient)
    {
        $this->callbackServerRepository = $callbackServerRepository;
        $this->vkApiClient = $vkApiClient;
    }


    public function handle(TokenCreated $event): void
    {
        if( $event->token->provider == VKConstants::VK_GROUP_PROVIDER ) {
            // TODO Why this line of code is here.
            $client = new Client();
            $callbackServer = $this->callbackServerRepository->findByField('projectId',$event->projectLink->projectId);
            $callbackServer = $callbackServer[0];
            $url = URL::route('callback', ['code' => $callbackServer->code, 'provider' => VKConstants::VK_GROUP_PROVIDER]);

            // TODO Check if callback server is already exists

            $result = $this->vkApiClient->groups()->addCallbackServer($event->token->token,[
                'group_id' => $event->token->providerId,
                'url' => $url,
                'title' => VKConstants::CALLBACK_TITLE,
                'v' => VKConstants::CALLBACK_VK_API_VERSION
            ]);

            if (array_key_exists('error', $result)) {
                throw new CallbackServerException($result);
            }
            $vkServerId = $result['server_id'];

             $result = $this->vkApiClient->groups()->getCallbackConfirmationCode($event->token->token,[
                'group_id' => $event->token->providerId,
                'v' => VKConstants::CALLBACK_VK_API_VERSION
            ]);

            if (array_key_exists('error', $result)) {
                throw new CallbackServerException($result);
            }
            $code = $result['code'];
            $updateWithCode = DBHelper::transactionOrFail(function () use ($code, $vkServerId, $callbackServer) {
                $data = [
                    'vk' => [
                        'confirmationCode' => $code,
                        'vkServerId' => $vkServerId,
                        'confirmed' => 0,
                    ]
                ];

                $updateWithCode = $this->callbackServerRepository->update( ['data' => $data], $callbackServer->id );
                return $updateWithCode;
            });
        }

    }
}
