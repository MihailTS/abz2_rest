<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    private static $attributesMap = [
        'id' => "id",
        'name' => "name",
        'password' => "password",
        'password_confirmation' => "password_confirmation",
        'email' => "email",
        'createdTime' => "created_at",
        'lastModifiedTime' => "modified_at",
        'deletedTime' => "deleted_at",
    ];

    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        $transformation = [
            'id' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'createTime' => (string)$user->created_at,
            'lastModifiedTime' => (string)$user->modified_at,
            'deletedTime' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];

        $transformation = array_filter($transformation);
        return $transformation;
    }

    public static function getOriginalAttributeName($index)
    {
        return isset(self::$attributesMap[$index]) ? self::$attributesMap[$index] : null;
    }

    public static function getTransformedAttributeName($index)
    {
        $transformedAttributesMap = array_flip(self::$attributesMap);
        return isset($transformedAttributesMap[$index]) ? $transformedAttributesMap[$index] : null;
    }
}
