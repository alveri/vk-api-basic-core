<?php


namespace App\Tokens\Repositories;

use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use App\Projects\Project;
use App\Tokens\Token;
use App\Tokens\Repositories\Criterias\TokenCriteria;
use Illuminate\Support\Facades\DB;

class TokenRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return \App\Tokens\Token::class;
    }


    public function boot(): void
    {
        $this->pushCriteria(new TokenCriteria());
    }
    /**
     * @param array $attributes
     * @return Token
     */
    public function findOrFail(array $attributes): Token
    {
        $query = Token::query();
        if ($attributes['projectId']) {
            $tokenIdsArray = [];
            $tokenIds = DB::table('project_links')->select('tokenId')->where('projectId', $attributes['projectId'])->get();
            foreach ($tokenIds as $token) {
                $tokenIdsArray[] = $token->tokenId;
            }
            $query = $query->whereIn('id', $tokenIdsArray);
        }
        unset($attributes['projectId']);
        $token = $query->where($attributes)->firstOrFail();

        return $token;
    }
}
