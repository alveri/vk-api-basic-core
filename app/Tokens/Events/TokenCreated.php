<?php

namespace App\Tokens\Events;

use App\Tokens\Token;
use App\Tokens\ProjectLink;
use Illuminate\Queue\SerializesModels;

class TokenCreated
{
    /**
     * @var Token
     */
    public Token $token;

    /**
     * @var ProjectLink
     */
    public ProjectLink $projectLink;

    /**
     * Create a new event instance.
     */
    public function __construct(Token $token, ProjectLink $projectLink)
    {
        $this->token = $token;
        $this->projectLink = $projectLink;
    }
}
