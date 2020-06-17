<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\DomainBadRequestException;

class UserBadRequestException extends DomainBadRequestException
{
    public $message = 'Bad Request';
}
