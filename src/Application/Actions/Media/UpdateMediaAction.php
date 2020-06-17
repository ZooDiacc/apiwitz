<?php
declare(strict_types=1);

namespace App\Application\Actions\Media;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Media\Media;
use App\Domain\Media\MediaNotFoundException;
use App\Domain\Media\MediaBadRequestException;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;

class UpdateMediaAction extends MediaAction
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

            if (!isset($this->request->getParsedBody()['content']) || empty($this->request->getParsedBody()['content'])) {
                throw new MediaBadRequestException();
            }
            if (!isset($this->request->getParsedBody()['url']) || empty($this->request->getParsedBody()['url'])) {
                throw new MediaBadRequestException();
            }
            if (!isset($this->request->getParsedBody()['type']) || empty($this->request->getParsedBody()['type'])
                || !($this->request->getParsedBody()['type'] == 'video' || $this->request->getParsedBody()['type'] == 'picture')) {
                throw new MediaBadRequestException();
            }
            if (!isset($this->request->getParsedBody()['is_active'])
                || ($this->request->getParsedBody()['is_active'] !== 0
                && $this->request->getParsedBody()['is_active'] !== 1)) {
                throw new MediaBadRequestException();
        }

        $media->content = $this->request->getParsedBody()['content'];
        $media->url = $this->request->getParsedBody()['url'];
        $media->type = $this->request->getParsedBody()['type'];
        $media->is_active = $this->request->getParsedBody()['is_active'];
        $media->updated_at = new \DateTime();
        $media->save();

        $this->logger->info("Media of id `${mediaId}` was updated.");

        return $this->respondWithData($media);
    }
}
