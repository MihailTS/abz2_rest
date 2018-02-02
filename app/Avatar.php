<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image;
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

    public function employee(){
        $this->belongsTo(Employee::class);
    }

    public function createThumbnail()
    {
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
        return $result;
    }

}
