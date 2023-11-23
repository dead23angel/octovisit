<?php

namespace Dead23Angel\OctoVisit\Behaviors;

use Dead23Angel\OctoVisit\Exceptions\VisitException;
use Dead23Angel\OctoVisit\Models\Visit;
use Dead23Angel\OctoVisit\PendingVisit;
use Dead23Angel\OctoVisit\Traits\FilterByPopularityTimeFrame;
use System\Classes\ModelBehavior;

/**
 * Visit model extension
 *
 * Usage:
 *
 * In the model class definition:
 *
 *   public $implement = ['Dead23Angel.OctoVisit.Behaviors.LocationModel'];
 *
 */
class VisitModel extends ModelBehavior
{
    use FilterByPopularityTimeFrame;

    public function __construct($model)
    {
        parent::__construct($model);

        $this->model->morphMany['visits'] = [
            Visit::class,
            'name' => 'visitable',
        ];
    }

    /**
     * keep track of your pages
     *
     * @return PendingVisit
     * @throws VisitException
     */
    public function visit(): PendingVisit
    {
        return new PendingVisit($this->model);
    }
}
