<?php

declare(strict_types=1);

namespace App\Model;

use Carbon\Carbon;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $is_admin
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['email', 'password', 'is_admin'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'is_admin' => 'boolean', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
