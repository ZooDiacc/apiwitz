<?php
declare(strict_types=1);

namespace App\Application\Actions\Media;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Media\Media;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;
use App\Domain\Media\MediaBadRequestException;

class CreateMediaAction extends MediaAction
{
    protected function action(): Response
    {
        $this->logger->info("Create media");

        $chapterId = (int) $this->resolveArg('chapterId');
        $chapter = Chapter::find($chapterId);

        if (!isset($chapter)) {
            throw new ChapterNotFoundException();
        }

        $media = new Media;

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
        $chapter->medias()->save($media);

        return $this->respondWithData($media, 201);
    }
}
