<?php

namespace App\Tokens\Providers;

use App\Identity\Models\Connection;
use App\Tokens\Observers\TokenVKKeyUpdateObserver;
use App\Tokens\Observers\TokenDeleteObserver;
use App\Tokens\Token;
use Carbon\Laravel\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Connection::observe(TokenVKKeyUpdateObserver::class);
        Token::observe(TokenDeleteObserver::class);

        $this->app->singleton(TokenRepository::class);
    }
}
