<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\DomainUnauthorizedException;

class UserUnauthorizedException extends DomainUnauthorizedException
{
    public $message = 'Invalid credentials.';
}
