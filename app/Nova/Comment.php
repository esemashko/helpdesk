<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\User;

class Comment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Comment>
     */
    public static $model = \App\Models\Comment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Trix::make('Comment', 'body'),

            Boolean::make('Is Public', 'is_public')->default(true),

            DateTime::make('Created At', 'created_at')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Ticket')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Author', 'author', User::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Fields\HasMany::make('Attachments', 'attachments', Attachment::class),

            /*File::make('Attachments', 'attachments')
                ->disk('public')
                ->path('attachments')*/
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
