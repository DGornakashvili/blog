<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class FilterService
{
    /**
     * @param Model $model
     * @param Request $request
     *
     * @return Builder
     */
    public static function setAll(Model $model, Request $request): Builder
    {
        if ($model instanceof News) {
            $builder = $model::query();
            $builder = self::setHeader($builder, $request);
        } elseif ($model instanceof Gallery) {
            $builder = $model::query();
            self::setTag($builder, $request);
        } else {
            $builder = $model::query();
        }

        return self::setDates($builder, $request);
    }

    /**
     * @param Builder $builder
     * @param Request $request
     *
     * @return Builder
     */
    public static function setDates(Builder $builder, Request $request): Builder
    {
        if (self::checkValue($request, 'from')) {
            $builder->where(
                'date',
                '>',
                Carbon::create($request['from'])->addDay()->toString()
            );
        }

        if (self::checkValue($request, 'to')) {
            $builder->where(
                'date',
                '<',
                Carbon::create($request['to'])->subDay()->toString()
            );
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param Request $request
     *
     * @return Builder
     */
    public static function setHeader(Builder $builder, Request $request): Builder
    {
        if (self::checkValue($request, 'header')) {
            $builder->where('header', '=', $request->header);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param Request $request
     *
     * @return Builder
     */
    public static function setTag(Builder $builder, Request $request): Builder
    {
        $builder->with([
            'tags' => function (BelongsToMany $query) use ($request) {
                $query->select(['id', 'name']);

                if (self::checkValue($request, 'tag')) {
                    $query->where('name', '=', $request->tag);
                }
            }
        ]);

        return $builder;
    }

    /**
     * @param Request $request
     * @param string $key
     *
     * @return bool
     */
    protected static function checkValue(Request $request, string $key): bool
    {
        return isset($request->{$key}) && !empty($request->{$key});
    }
}
