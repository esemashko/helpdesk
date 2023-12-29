<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaAttachMany\AttachMany;

class Company extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Company>
     */
    public static $model = \App\Models\Company::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')
                ->sortable()
                ->required()
                ->showOnPreview()
                ->showWhenPeeking()
                ->textAlign('left'),

            Text::make('Phone Number')
                ->showOnPreview()
                ->textAlign('left'),

            Email::make('Email')
                ->showOnPreview()
                ->textAlign('left'),

            URL::make('Website')
                ->showOnPreview()
                ->textAlign('left'),

            Text::make('Address')
                ->showOnPreview()
                ->textAlign('left'),

            Markdown::make('Description')
                ->showOnPreview()
                ->alwaysShow()
                ->textAlign('left'),


            BelongsToMany::make('Users', 'users', User::class)
                ->showCreateRelationButton()
                ->sortable()
                ->nullable()
                ->textAlign('left'),

           // HasManyThrough::make('Users')
           //     ->textAlign('left'),

            HasMany::make('Tickets'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
