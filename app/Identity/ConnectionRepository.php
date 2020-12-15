<?php

namespace App\Identity;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Identity\Models\Connection;

class ConnectionRepository extends BaseRepository
{
    protected array $fieldSearchable = [
        'userId',
        'provider',
        'providerId',
        'token'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Identity\Models\Connection::class;
    }

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
    /**
     * @param int $userId
     * @return Connection|null
     */
    public function getVkConnection(int $userId)
    {
        return Connection::first([
            'userId' => $userId,
            'provider' => Connection::PROVIDER_VKONTAKTE
        ]);
    }

    public function vk_connection(int $userId)
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where('userId', $userId)->where('provider', Connection::PROVIDER_VKONTAKTE)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }
}
