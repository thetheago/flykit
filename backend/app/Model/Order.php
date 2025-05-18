<?php

declare(strict_types=1);

namespace App\Model;

use App\OrderState\OrderStateFactory;
use App\OrderState\OrderStateInterface;
use Hyperf\DbConnection\Model\Model;
use Hyperf\ModelListener\Annotation\ModelListener;
use Hyperf\ModelListener\Contract\ModelListenerInterface;

/**
 * @property int $id 
 * @property int $order_number 
 * @property string $requester_name 
 * @property string $destination 
 * @property string $departure_date 
 * @property string $arrival_date 
 * @property string $status 
 * @property int $user_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Order extends Model
{
    private ?OrderStateInterface $state = null;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'order_id',
        'requester_name',
        'destination',
        'departure_date',
        'arrival_date',
        'status',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'user');
    }

    public function belongsToUser(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    public function initializeState(): void
    {
        $this->state = OrderStateFactory::createFromStatus($this->status);
    }

    public function setState(OrderStateInterface $state): void
    {
        $this->state = $state;
        $this->status = $state->getStatus();
    }

    public function approve(): void
    {
        $this->state->approve($this);
    }

    public function request(): void
    {
        $this->state->request($this);
    }

    public function cancel(): void
    {
        $this->state->cancel($this);
    }
}
