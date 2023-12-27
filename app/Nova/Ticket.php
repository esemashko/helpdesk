<?php

namespace App\Nova;

use Esemashko\ColorBadge\ColorBadge;
use Esemashko\NameStatus\NameStatus;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Ticket extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Ticket>
     */
    public static $model = \App\Models\Ticket::class;

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

    private bool $isUserSupport;

    public function subtitle()
    {
        return "Priority: {$this->priority->name}";
    }

    public function __construct($resource = null)
    {
        parent::__construct($resource);

        $this->isUserSupport = \App\Models\User::where('id', auth()->user()->id)
            ->whereHas('companies', function ($query) {
                $query->where('companies.id', 1);
            })->exists();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [

            NameStatus::make('Name')
                ->sortable()
                ->required()
                ->showOnIndex()
                ->showOnCreating(false)
                ->showOnUpdating(false)
                ->showOnDetail(false)
                ->textAlign('left')
                ->resolveUsing(function ($value, $resource) {
                    return [
                        'name' => $resource->name,
                        'priority' => $resource->priority,
                    ];
                }),

            Text::make('Name')
                ->required()
                ->showOnIndex(false)
                ->showOnCreating()
                ->showOnUpdating()
                ->showOnDetail()
                ->textAlign('left'),

            ColorBadge::make('Priority')
                ->showOnIndex(false)
                ->showOnCreating(false)
                ->showOnUpdating(false)
                ->showOnDetail(),

            BelongsTo::make('Priority')
                ->sortable()
                ->required()
                ->showOnIndex(false)
                ->showOnCreating()
                ->showOnUpdating()
                ->showOnDetail(false)
                ->filterable() // TODO фильтр сделать ко всем
                ->default(function () {
                    return \App\Models\Priority::where('is_default', true)->first()->id;
                })
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->reorder()->orderBy('sort', 'asc')->orderBy('id', 'desc');
                })
                ->dontReorderAssociatables()
                ->textAlign('left'),


            Trix::make('Description')
                ->sortable()
                ->nullable()
                ->alwaysShow()
                ->fullWidth()
                ->textAlign('left'),

            new Panel('Company', $this->companyFields()),
            new Panel('Responsibility', $this->responsibleFields()),
            new Panel('Info', $this->infoFields()),

            ColorBadge::make('Status')
                //->sortable() TODO не работает
                ->showOnIndex()
                ->showOnCreating(false)
                ->showOnUpdating(false)
                ->showOnDetail(),
        ];
    }

    protected function responsibleFields(): array
    {
        return [
            BelongsTo::make('Responsible', 'responsible', User::class)
                ->sortable()
                ->textAlign('left')
                ->default(function () {
                    return auth()->user()->id;
                })
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereHas('companies', function ($query) {
                        $query->where('companies.id', 1);
                    });
                })
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),
        ];
    }

    protected function companyFields(): array
    {
        return [
            BelongsTo::make('Company')
                ->sortable()
                //->showWhenPeeking()
                /*->default(function () {
                    return auth()->user()->company_id;
                })*/
                ->textAlign('left'),

            BelongsTo::make('Contact', 'client', User::class)
                ->sortable()
                ->textAlign('left')
                ->showWhenPeeking()
                ->default(function () {
                    return auth()->user()->id;
                })
                ->dependsOn('company', function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    $companyId = $formData->company;
                    if (empty($companyId)) {
                        $field->hide();
                    }
                    $field->relatableQueryUsing(function (NovaRequest $request, $query) use ($companyId) {
                        return $query->whereHas('companies', function ($query) use ($companyId) {
                            $query->where('companies.id', $companyId);
                        });
                    });

                }),
        ];
    }

    protected function infoFields(): array
    {
        return [
            DateTime::make('Created At')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            DateTime::make('Updated At')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Status Updated At')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            DateTime::make('Resolution Deadline')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Response Date')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('First Response')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Closed Date')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            BelongsTo::make('Author', 'author', User::class)
                ->sortable()
                ->textAlign('left')
                ->showOnIndex(false)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->default(function () {
                    return auth()->user()->id;
                }),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            //new TicketPriority()
        ];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [

        ];
    }
}
