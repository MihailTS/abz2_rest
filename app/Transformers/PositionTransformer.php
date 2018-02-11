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
    public function transform(Position $position): array
    {
        $transformation = [
            'id' => (int)$position->id,
            'name' => (string)$position->name,
            'createTime' => (string)$position->created_at,
            'lastModifiedTime' => (string)$position->modified_at,
            'deletedTime' => isset($position->deleted_at) ? (string)$position->deleted_at : null,

            'links' => $this->getLinksArray($position)
        ];

        $transformation = array_filter($transformation);
        return $transformation;
    }

    private function getLinksArray(Position $position): array
    {
        $links = [
            [
                'rel' => 'self',
                'href' => route('positions.show', $position->id)
            ]
        ];

        $links = array_filter($links);
        $links = array_values($links);

        return $links;
    }

    public static function getOriginalAttributeName($index)
    {
        return isset(self::$attributesMap[$index]) ? self::$attributesMap[$index] : null;
    }
}
