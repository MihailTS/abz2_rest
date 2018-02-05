<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class Avatar extends Model
{
    public const AVATAR_PATH = "public/storage/avatars";
    public const THUMBNAIL_PATH = "public/storage/thumbnails";
    private const THUMBNAIL_WIDTH = 200;

    protected $fillable = [
        'path',
        'thumbnail'
    ];

    public static function boot()
    {
        parent::boot();

        //запуск создания уменьшенной картинки при создании и изменении
        self::created(function ($avatar) {
            $avatar->createThumbnail();
        });
        self::updated(function ($avatar) {
            $avatar->createThumbnail();
        });
    }

    public function employee(){
        $this->belongsTo(Employee::class);
    }

    /**
     * Создает уменьшенную копию аватара пользователя
     *
     * @return \Image сохраненная уменьшенная картинка
     */
    public function createThumbnail()
    {
        $result=false;
        if(!is_null($this->path())){
            $image = \Image::make($this->path);
            $thumbPath = Avatar::THUMBNAIL_PATH . "/" . basename($this->path);
            $ratio = $image->height() / $image->width();
            if (!File::exists(Avatar::THUMBNAIL_PATH)) {
                File::makeDirectory(Avatar::THUMBNAIL_PATH);
            }
            $heightWithSaveRatioThumb = intval(self::THUMBNAIL_WIDTH * $ratio);
            $avatarThumbnail = \Image::make($image)->fit(self::THUMBNAIL_WIDTH, $heightWithSaveRatioThumb);
            $result = $avatarThumbnail->save($thumbPath);
            if ($result != null) {
                $this->thumbnail = $thumbPath;
                $this->save();
            }
        }
        return $result;
    }

}
