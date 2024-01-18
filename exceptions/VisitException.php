<?php

namespace CWTeam\OctoVisit\Exceptions;

use CWTeam\OctoVisit\Behaviors\VisitModel;
use Exception;
use October\Rain\Database\Model;

class VisitException extends Exception
{
    /**
     * Method for Presenter Implementation absence on the model
     * @param Model $model
     * @return self
     */
    public static function interfaceNotImplemented(Model $model): self
    {
        return new self((
            __(':model should implements :implement', [
                'model' => get_class($model),
                'implement' => VisitModel::class,
            ])
        ));
    }
}
