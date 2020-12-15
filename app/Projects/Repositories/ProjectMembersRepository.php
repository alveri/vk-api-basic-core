<?php

namespace App\Projects\Repositories;

use App\Core\Facades\DBHelper;
use App\Projects\ProjectMember;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ProjectMembersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'projectId',
        'tokenId',
        'role'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Projects\ProjectMember::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
    /**
     * @param int $projectId
     * @return Project|null
     */
    public function getProjectMember(int $projectId, int $memberId)
    {
        return ProjectMember::where('userId', $memberId)
               ->where('projectId', $projectId)
               ->first();
    }

    public function getProjectAdmins(int $projectId)
    {
        return ProjectMember::where('role', 'admin')
                  ->where('projectId', $projectId)
                  ->get();
    }

    public function addMembers(int $projectId, array $members): void
    {
        foreach ($members as $memberId => $role) {
            $projectMember = DBHelper::transactionOrFail(function () use ($memberId, $role, $projectId) {
                $projectMember = $this->firstOrNew(['projectId'=> $projectId, 'userId'=>$memberId]);
                $projectMember->role = $role;
                $projectMember->save();
                return $projectMember;
            });
        }
    }

    public function removeMember(int $projectId, int $memberId): void
    {
        $projectMember = DBHelper::transactionOrFail(function () use ($memberId, $projectId) {
            $projectMember = $this->find(['projectId'=> $projectId, 'userId'=>$memberId]);
            return($this->delete($projectMember[0]->id));
        });
    }
}
