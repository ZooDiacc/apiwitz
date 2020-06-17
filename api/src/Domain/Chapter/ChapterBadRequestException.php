<?php
declare(strict_types=1);

namespace App\Domain\Chapter;

use App\Domain\DomainException\DomainBadRequestException;

class ChapterBadRequestException extends DomainBadRequestException
{
    public $message = 'Bad Request';
}
