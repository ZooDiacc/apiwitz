<?php
declare(strict_types=1);

namespace App\Application\Actions\Chapter;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chapter\Chapter;
use App\Domain\Chapter\ChapterNotFoundException;
use App\Domain\Chapter\ChapterBadRequestException;

class UpdateChapterAction extends ChapterAction
{
    protected function action(): Response
    {
        $chapterId = (int) $this->resolveArg('chapterId');
        $chapter = Chapter::find($chapterId);
        if (!$chapter)
            throw new ChapterNotFoundException();

        if (!isset($this->request->getParsedBody()['title']) || empty($this->request->getParsedBody()['title'])) {
            throw new ChapterBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['content']) || empty($this->request->getParsedBody()['content'])) {
            throw new ChapterBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['slug']) || empty($this->request->getParsedBody()['slug'])) {
            throw new ChapterBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['titlenumber']) || empty($this->request->getParsedBody()['titlenumber'])) {
            throw new ChapterBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['background']) || empty($this->request->getParsedBody()['background'])) {
            throw new ChapterBadRequestException();
        }
        if (!isset($this->request->getParsedBody()['is_active'])
            || ($this->request->getParsedBody()['is_active'] !== 0
            && $this->request->getParsedBody()['is_active'] !== 1)) {
            throw new ChapterBadRequestException();
        }

        $chapter->title = $this->request->getParsedBody()['title'];
        $chapter->content = $this->request->getParsedBody()['content'];
        $chapter->slug = $this->request->getParsedBody()['slug'];
        $chapter->titlenumber = $this->request->getParsedBody()['titlenumber'];
        $chapter->background = $this->request->getParsedBody()['background'];
        $chapter->is_active = $this->request->getParsedBody()['is_active'];
        $chapter->updated_at = new \DateTime();
        $chapter->save();

        $this->logger->info("Chapter of id `${chapterId}` was updated.");

        return $this->respondWithData($chapter);
    }
}
