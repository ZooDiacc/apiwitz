<?php
namespace App\Domain\Chapter;

class Chapter extends \Illuminate\Database\Eloquent\Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chapter';

    /**
     * Get the medias for the chapter.
     */
    public function medias()
    {
        return $this->hasMany('App\Domain\Media\Media');
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['medias'];
}
