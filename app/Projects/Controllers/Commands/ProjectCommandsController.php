<?php

namespace App\Projects\Controllers\Commands;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller;
use App\Core\Facades\DBHelper;
use App\Projects\Repositories\ProjectMembersRepository;
use App\Projects\Repositories\ProjectRepository;
use App\Core\Exceptions\PermissionsException;
use App\Core\Http\Responses\SuccessResponse;
use App\Projects\Requests\ValidProjectRequest;
use App\Projects\Requests\ValidProjectByIdRequest;
use App\Projects\ProjectMember;
use App\Projects\Events\ProjectCreated;
use Illuminate\Http\Response;

class ProjectCommandsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private ProjectRepository $repository;

    /**
     * @var ProjectMembersRepository
     */
    private ProjectMembersRepository $membersRepository;

    public function __construct(ProjectRepository $repository, ProjectMembersRepository $projectMembersRepository)
    {
        $this->repository = $repository;
        $this->membersRepository = $projectMembersRepository;
        $this->middleware('auth');
    }


    public function createProjectWithMember(ValidProjectRequest $request): Response
    {
        $project = DBHelper::transactionOrFail(function () use ($request) {
            $project = $this->repository->create($request->all());

            $projectMember = $this->membersRepository->create([
                  'userId' => Auth::user()->id,
                  'projectId' => $project->id,
                  'rove' => 'admin',
              ]);

            return $project;
        });

        event(new ProjectCreated($project));

        return SuccessResponse::json(['newProjectId' => $project->id]);
    }

    public function archive(ValidProjectByIdRequest $request): Response
    {
        $id = $request->input('projectId');
        $this->checkPermissions($id);
        $project = DBHelper::transactionOrFail(function () use ($id) {
            $project = $this->repository->update(['isArchived' => 1], $id);
            return $project;
        });

        return SuccessResponse::json();
    }

    public function unArchive(ValidProjectByIdRequest $request): Response
    {
        $id = $request->input('projectId');
        $this->checkPermissions($id);
        $project = DBHelper::transactionOrFail(function () use ($id) {
            $project = $this->repository->update(['isArchived' => 0], $id);
            return $project;
        });
        return SuccessResponse::json();
    }


    private function checkPermissions($projectId): void
    {
        if (Gate::denies('able-to-edit', $projectId)) {
            throw new PermissionsException();
        }
    }
}
