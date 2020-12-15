<?php


namespace App\Tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Token\Token
 *
 * @property int $id
 * @property string $token
 * @property string $provider
 * @property string|null $providerId
 * @property int $userId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Token\ProjectLink $projectLink
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Token\Token whereUserId($value)
 * @mixin \Eloquent
 */
class Token extends Model
{
    protected $fillable = ['token', 'provider', 'providerId', 'userId'];


    public function projectLinks()
    {
        return $this->hasMany(\App\Tokens\ProjectLink::class, 'project_links', 'tokenId');
    }
}
