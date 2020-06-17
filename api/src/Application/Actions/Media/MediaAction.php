<?php
declare(strict_types=1);

namespace App\Application\Actions\Media;

use App\Application\Actions\Action;
use App\Domain\Media\Media;
use Psr\Log\LoggerInterface;

abstract class MediaAction extends Action
{
    /**
    * @var Media
    */
    protected $media;
    
    /**
    * @param LoggerInterface $logger
    * @param Media  $media
    */
    public function __construct(LoggerInterface $logger, Media $media)
    {
        parent::__construct($logger);
        $this->media = $media;
    }
}