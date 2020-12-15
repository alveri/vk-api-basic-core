<?php

namespace App\Engine\Plugins;

use App\Engine\Contracts\FilterPlugin;
use App\Engine\Models\EventFilter;
use App\Engine\Repositories\VkGroupFilterExtensionRepository;
use App\Core\Facades\DBHelper;
use App\Common\VKConstants;
use Prettus\Repository\Criteria\RequestCriteria;

class VkGroupFilterPlugin implements FilterPlugin
{

    /**
     * @var VkGroupFilterExtensionRepository
     */
    private VkGroupFilterExtensionRepository $repository;


    public function __construct(VkGroupFilterExtensionRepository $repository)
    {
        $this->repository = $repository;
    }


    public function eventFilterCreated(EventFilter $filter): void
    {
        $groupId = $filter->data['providerId'];
        if( in_array($filter->data['eventType'], VKConstants::ALLOWED_EVENTS)) {
            $vkGroupFilterExtension = DBHelper::transactionOrFail(function () use ($filter, $groupId) {
                $vkGroupFilterExtension = $this->repository->create([
                    'projectId' => $filter->projectId,
                    'eventFilterId' => $filter->id,
                    'groupId' => $groupId,
                ]);
                return $vkGroupFilterExtension;
            });
        }
    }

    public function eventFilterRemoved(EventFilter $filter): void
    {
        $vkGroupFilterExtensionDeleted = DBHelper::transactionOrFail(function () use ($filter) {
            $vkGroupFilterExtensionDeleted = $this->repository->deleteWhere([
                'eventFilterId' => $filter->id,
            ]);
            return $vkGroupFilterExtensionDeleted;
        });
    }
}
