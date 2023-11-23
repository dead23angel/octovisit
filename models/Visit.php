<?php

namespace Dead23Angel\OctoVisit\Models;

use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Dead23Angel\OctoVisit\Presenters\VisitPresenter;
use Model;

/**
 * @property int $id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Visit extends Model implements CanPresent
{
    use UsesPresenters;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "dead23angel_octovisit_visits";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * The classes that should be present
     *
     * @var array
     */
    protected $presenters = [
        'default' => VisitPresenter::class,
    ];

    public $morphTo = [
        'visitable' => []
    ];
}
