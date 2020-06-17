<?php
declare(strict_types=1);

namespace App\Application\Actions\Media;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Media\Media;
use App\Domain\Chapter\Chapter;
use App\Domain\Media\MediaNotFoundException;
use App\Domain\Chapter\ChapterNotFoundException;

class DeleteMediaAction extends MediaAction
{
    protected function action(): Response
    {
        $chapterId = (int) $this->resolveArg('chapterId');
        $mediaId = (int) $this->resolveArg('mediaId');
        $chapter = Chapter::find($chapterId);

        if (!isset($chapter)) {
            throw new ChapterNotFoundException();
        }

        $media = $chapter->medias->where('id', $mediaId)->first();
        if (!isset($media))
            throw new MediaNotFoundException();

        $media->delete();

        $this->logger->info("Media of id `${mediaId}` was deleted.");

        return $this->respondWithData();
    }
}
