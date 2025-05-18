<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class OrderStatus extends AbstractConstants
{
    /**
     * @Message("Requested")
     */
    public const REQUESTED = 'requested';

    /**
     * @Message("Approved")
     */
    public const APPROVED = 'approved';

    /**
     * @Message("Cancelled")
     */
    public const CANCELLED = 'cancelled';
    
    
}
