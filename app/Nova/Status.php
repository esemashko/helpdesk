<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Status extends Resource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Status>
     */
    public static $model = \App\Models\Status::class;

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
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')
                ->rules('required', 'max:255', 'unique:statuses,name,{{resourceId}}')
                ->showOnPreview()
                ->textAlign('left'),

            Text::make('Button')
                ->rules('required', 'max:255', 'unique:statuses,button,{{resourceId}}')
                ->showOnPreview()
                ->textAlign('left'),

            Color::make('Color')
                ->showOnPreview()
                ->textAlign('left'),

            Number::make('Sort')
                ->showOnIndex(false)
                ->showOnCreating(false)
                ->showOnUpdating(false)
                ->textAlign('left'),

            Boolean::make('Is Default', 'is_default')
                ->showOnPreview()
                ->textAlign('left'),

            Boolean::make('Is Final', 'is_final')
                ->showOnPreview()
                ->textAlign('left'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
