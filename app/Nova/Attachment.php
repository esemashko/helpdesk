<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Attachment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Attachment>
     */
    public static $model = \App\Models\Attachment::class;

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
     * @param NovaRequest $request
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('file_name')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromDetail(),

            BelongsTo::make('Comment')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Author', 'author', User::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            File::make('File', 'file_path')
                ->disk('public')
                ->path('ticket')
                ->storeAs(function (Request $request) {
                    return $this->generateUniqueFilePath($request);
                })
                ->rules('required', 'mimes:pdf,docx,doc,xls,xlsx,ppt,pptx,txt,zip,rar,7z,png,jpg,jpeg,gif,svg')
                ->prunable()
                ->creationRules('unique:attachments,file_path')
                ->updateRules('unique:attachments,file_path,{{resourceId}}'),
        ];
    }

    public function generateUniqueFilePath(Request $request): string
    {
        $file = $request->file('file_path');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $date = date('Y_m_d');
        $uniqueId = uniqid('', false);

        return "{$date}/{$uniqueId}/{$originalFileName}.{$extension}";
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
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
     * @param NovaRequest $request
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
     * @param NovaRequest $request
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
     * @param NovaRequest $request
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
