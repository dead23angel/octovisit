<?php

namespace CWTeam\OctoVisit\Presenters;

use Coderflex\LaravelPresenter\Presenter;
use CWTeam\OctoVisit\Models\User;
use Model;

class VisitPresenter extends Presenter
{
    /**
     * Get the associated IP from the model instance
     *
     * @return string
     */
    public function ip(): string
    {
        return $this->model->data['ip'];
    }

    /**
     * Get the associated User from the model instance
     *
     * @return Model
     */
    public function user(): Model
    {
        $userId = $this->model->data['user_id'];
        $userNamespace = config('dead23angel.octovisit::octovisit.user_namespace');

        $user = is_null($userNamespace) || empty($userNamespace)
                ? User::class
                : $userNamespace;

        return (new $user())->find($userId);
    }
}
