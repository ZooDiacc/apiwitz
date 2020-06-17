<?php
namespace App\Domain\Media;

class Media extends \Illuminate\Database\Eloquent\Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    public function post()
    {
        return $this->belongsTo('App\Domain\Chapter\Chapter');
    }
}
