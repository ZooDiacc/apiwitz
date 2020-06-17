<?php
declare(strict_types=1);

namespace App\Application\Actions\Media;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;

class ListMediasAction extends MediaAction
{
    protected function action(): Response
    {
        $chapterId = (int) $this->resolveArg('chapterId');
        $chapter = Chapter::find($chapterId);

        if (!isset($chapter)) {
            throw new ChapterNotFoundException();
        }

        $medias = $chapter->medias;

        return $this->respondWithData($medias);
    }
}
