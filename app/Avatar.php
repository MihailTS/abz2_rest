<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Avatar extends Model
{
    use SoftDeletes;

    private const THUMBNAIL_WIDTH = 200;

    protected $dates = ['deleted_at'];
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

        self::updating(function($avatar){
            $avatar->deleteFiles();
        });

        self::updated(function ($avatar) {
            if ($avatar->isDirty) {
                $avatar->createThumbnail();
            }
        });

        self::deleted(function($avatar){
           $avatar->deleteFiles();
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
        if (!is_null($this->path)) {
            $thumbPath = "thumbnails" . "/" . basename($this->path);

            $image = \Image::make($this->path);
            $ratio = $image->height() / $image->width();
            $heightWithSaveRatioThumb = intval(Avatar::THUMBNAIL_WIDTH * $ratio);
            $avatarThumbnail = \Image::make($image)->fit(Avatar::THUMBNAIL_WIDTH, $heightWithSaveRatioThumb);

            $result = Storage::disk('avatars')->put($thumbPath, $avatarThumbnail);
            if ($result != null) {
                $this->thumbnail = $thumbPath;
                $this->save();
            }
        }
        return $result;
    }

    /**
     *  удаляет файл аватара и изображение для предпросмотра
     */
    private function deleteFiles(){
        Storage::disk('avatars')->delete($this->path);
        Storage::disk('avatars')->delete($this->thumbnail);
    }

}
