<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{
    private $perPage = 15;

    private function successResponce($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponce($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponce(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection, $transformer);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);
        return $this->successResponce($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponce($instance, $code);
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::getOriginalAttributeName(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::getOriginalAttributeName($query);
            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }
        return $collection;
    }

    protected function paginate(Collection $collection, $transformer)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $results = $collection->slice(($page - 1) * $this->perPage, $this->perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $this->perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();

        return Cache::remember($url, 30 / 60, function () use ($data) {
            return $data;
        });
    }
}
