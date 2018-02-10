<?php

namespace App\Transformers;

use App\Position;
use League\Fractal\TransformerAbstract;

class PositionTransformer extends TransformerAbstract
{

    private static $attributesMap = [
        'id' => "id",
        'name' => "name",
        'createdTime' => "created_at",
        'lastModifiedTime' => "modified_at",
        'deletedTime' => "deleted_at",
    ];

    /**
     * A Fractal transformer.
     *
     * @param Position $position
     * @return array
     */
    public function transform(Position $position)
    {
        return [
            'id' => (int)$position->id,
            'name' => (string)$position->name,
            'createTime' => (string)$position->created_at,
            'lastModifiedTime' => (string)$position->modified_at,
            'deletedTime' => isset($position->deleted_at) ? (string)$position->deleted_at : null
        ];
    }

    public static function getOriginalAttributeName($index)
    {
        return isset(self::$attributesMap[$index]) ? self::$attributesMap[$index] : null;
    }
}
