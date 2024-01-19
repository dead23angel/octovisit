<?php

namespace CWTeam\OctoVisit\Presenters;

use Coderflex\LaravelPresenter\Presenter;
use CWTeam\OctoVisit\Models\User;
use Illuminate\Support\Arr;
use October\Rain\Database\Model;

class VisitPresenter extends Presenter
{
    /**
     * Get the associated IP from the model instance
     *
     * @return string
     */
    public function ip(): string
    {
        return Arr::get($this->model->data, 'ip', '-');
    }

    /**
     * Get the associated User from the model instance
     *
     * @return Model|null
     */
    public function user(): ?Model
    {
        $userId = Arr::get($this->model->data, 'user_id');
        $userNamespace = config('cwteam.octovisit::octovisit.user_namespace');

        $user = is_null($userNamespace) || empty($userNamespace)
                ? User::class
                : $userNamespace;

        return (new $user())->find($userId);
    }
}
