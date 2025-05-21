<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class AuthConstants extends AbstractConstants
{
    /**
     * @Message("Name of jwt token.")
     */
    public const TOKEN_NAME = 'Secret-Token';
}
