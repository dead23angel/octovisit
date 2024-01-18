<?php

namespace CWTeam\OctoVisit\Behaviors;

use CWTeam\OctoVisit\Exceptions\VisitException;
use CWTeam\OctoVisit\Models\Visit;
use CWTeam\OctoVisit\PendingVisit;
use CWTeam\OctoVisit\Traits\FilterByPopularityTimeFrame;
use System\Classes\ModelBehavior;

/**
 * Visit model extension
 *
 * Usage:
 *
 * In the model class definition:
 *
 *   public $implement = ['CWTeam\OctoVisit\Behaviors\CWTeam'];
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
