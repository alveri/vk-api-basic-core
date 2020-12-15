<?php


namespace App\Vk\Groups\Jobs;

use App\Token\Token;
use App\Vk\CallbackController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use VK\Client\VKApiClient;

class SetupCallbackServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $groupId;

    /**
     * @var Token
     */
    private $credentials;

    public function __construct(Token $credentials, int $groupId)
    {
        $this->groupId = $groupId;
        $this->credentials = $credentials;
    }

    public function handle(VKApiClient $vk)
    {
        $servers = $vk->groups()->getCallbackServers($this->credentials->token, [
            'group_id' => $this->groupId
        ]);

        $callbackUrl = CallbackController::callbackUrl();

        foreach ($servers as $server) {
            if ($server['url'] === $callbackUrl) {
                return;
            }
        }

        $serverId = $vk->groups()->addCallbackServer($this->credentials->token, [
            'group_id' => $this->groupId,
            'url' => $callbackUrl,
            'title' => 'Autopilot callback'
        ]);
    }
}
