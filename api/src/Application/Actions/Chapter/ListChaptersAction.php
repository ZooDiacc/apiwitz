<?php
declare(strict_types=1);

namespace App\Application\Actions\Chapter;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Chapter\Chapter;

class ListChaptersAction extends ChapterAction
{
    protected function action(): Response
    {
        $allChapters = Chapter::get();
        return $this->respondWithData($allChapters);
    }
}
