<?php


namespace App\Tokens\Observers;

use App\Identity\Models\Connection;

class TokenVKKeyUpdateObserver
{
    // Todo unit test when social connection token is changed, change token.
    public function saved(Connection $connection): void
    {
        if ($connection->provider === Connection::PROVIDER_VKONTAKTE_GROUP) {
            /**
             * @var $token Token
             */
            $token = Token::query()
                ->where([
                    'userId' => $connection->userId,
                    'provider' => $connection->provider,
                    'providerId' => $connection->providerId
                ])
                ->first();

            if ($token && $token->token !== $connection->token) {
                $token->token = $connection->token;
                $token->save();
            }
        }
    }
}
