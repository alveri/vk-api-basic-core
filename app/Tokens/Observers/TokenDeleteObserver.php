<?php


namespace App\Tokens\Observers;

use App\Tokens\ProjectLink;
use App\Tokens\Token;
use App\Core\Facades\DBHelper;

class TokenDeleteObserver
{
    public function deleted(Token $token): void
    {
        $token = DBHelper::transactionOrFail(function () use ($token) {
            return(ProjectLink::where('tokenId', $token->id)->delete());
        });
    }
}
