<?php
declare(strict_types=1);

namespace App\Application\Actions\Chapter;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;

class ViewChapterAction extends ChapterAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chapterId = (int) $this->resolveArg('chapterId');
        $chapter = Chapter::find($chapterId);

        if (!$chapter)
            throw new ChapterNotFoundException();
        $this->logger->info("Chapter of id `${chapterId}` was viewed.");

        return $this->respondWithData($chapter);

    }
}
