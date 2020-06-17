<?php
declare(strict_types=1);

namespace App\Domain\Media;

use App\Domain\DomainException\DomainRecordNotFoundException;

class MediaNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The media you requested does not exist.';
}
