<?php
declare(strict_types=1);

namespace App\Application\Actions\Chapter;

use App\Application\Actions\Action;
use App\Domain\Chapter\Chapter;
use Psr\Log\LoggerInterface;

abstract class ChapterAction extends Action
{
    /**
    * @var Chapter
    */
    protected $chapter;
    
    /**
    * @param LoggerInterface $logger
    * @param Chapter  $chapter
    */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
}