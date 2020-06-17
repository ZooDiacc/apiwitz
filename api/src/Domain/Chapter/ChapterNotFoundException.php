<?php
declare(strict_types=1);

namespace App\Domain\Chapter;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ChapterNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The chapter you requested does not exist.';
}
