<?php

namespace App\Nova;

use Esemashko\ColorBadge\ColorBadge;
use Esemashko\NameStatus\NameStatus;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
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
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    private bool $isUserSupport;

    public function __construct($resource = null)
    {
        parent::__construct($resource);

        $this->isUserSupport = \App\Models\User::where('id', auth()->user()->id)
            ->whereHas('companies', function ($query) {
                $query->where('companies.id', 1);
            })->exists();
    }

    public function subtitle()
    {
        return "Priority: {$this->priority->name}";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     *
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [

            NameStatus::make('Name')
                ->textAlign('left')
                ->sortable()
                ->required()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->resolveUsing(function ($value, $resource) {
                    return [
                        'name' => $resource->name,
                        'priority' => $resource->priority,
                    ];
                }),

            Text::make('Name')
                ->textAlign('left')
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            ColorBadge::make('Priority')
                ->textAlign('left')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Priority')
                ->textAlign('left')
                ->required()
                ->filterable()
                ->hideFromIndex()
                ->hideFromDetail()
                ->default(function () {
                    return \App\Models\Priority::where('is_default', true)->first()->id;
                })
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->reorder()->orderBy('sort', 'asc')->orderBy('id', 'desc');
                })
                ->dontReorderAssociatables(),

            Trix::make('Description')
                ->textAlign('left')
                ->sortable()
                ->nullable()
                ->alwaysShow()
                ->fullWidth()
                ->hideFromIndex(),

            new Panel('Company', $this->companyFields()),
            new Panel('Responsibility', $this->responsibleFields()),
            new Panel('Info', $this->infoFields()),

            ColorBadge::make('Status')
                ->showOnIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            HasMany::make('Comments')
                ->textAlign('left'),

        ];
    }

    protected function companyFields(): array
    {
        return [
            BelongsTo::make('Company')
                ->textAlign('left')
                ->sortable(),

            BelongsTo::make('Contact', 'client', User::class)
                ->textAlign('left')
                ->sortable()
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

    protected function responsibleFields(): array
    {
        return [
            BelongsTo::make('Responsible', 'responsible', User::class)
                ->textAlign('left')
                ->sortable()
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

    protected function infoFields(): array
    {
        return [
            DateTime::make('Created At')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Status Updated At')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Resolution Deadline')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromDetail()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Response Date')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('First Response')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->canSee(function ($request) {
                    return $this->isUserSupport;
                }),

            DateTime::make('Closed Date')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Author', 'author', User::class)
                ->textAlign('left')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
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
