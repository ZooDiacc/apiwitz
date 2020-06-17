<?php
declare(strict_types=1);

namespace App\Application\Actions\Chapter;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;

class DeleteChapterAction extends ChapterAction
{
    protected function action(): Response
    {
        $chapterId = (int) $this->resolveArg('chapterId');
        $chapter = Chapter::find($chapterId);
        if (!$chapter)
            throw new ChapterNotFoundException();

        $chapter->delete();

        $this->logger->info("Chapter of id `${chapterId}` was deleted.");

        return $this->respondWithData();
    }
}
