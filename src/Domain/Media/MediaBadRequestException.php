<?php
declare(strict_types=1);

namespace App\Domain\Media;

use App\Domain\DomainException\DomainBadRequestException;

class MediaBadRequestException extends DomainBadRequestException
{
    public $message = 'Bad Request';
}
