<?php


namespace App\Vk;

use App\Identity\ConnectionRepository;
use App\Identity\Models\User;
use VK\Client\VKApiClient;
use function abort;

class VkApiRepository
{

    /**
     * @var ConnectionRepository
     */
    private $repo;
    /**
     * @var VKApiClient
     */
    private $client;

    public function __construct(ConnectionRepository $repo, VKApiClient $client)
    {
        $this->repo = $repo;
        $this->client = $client;
    }

    public function getMyVkGroups(User $user)
    {
        $connection = $this->repo->getVkConnection($user->id);
        if (!$connection) {
            abort('404', 'User must have VK authentication');
        }

        $groups = $this->client->groups()->get($connection->token, [
            'filter' => 'admin',
            'extended' => 1
        ]);

        return $groups;
    }
}
