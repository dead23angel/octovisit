<?php namespace CWTeam\OctoVisit\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * VisitsCount Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class VisitsCount extends FormWidgetBase
{
    protected $defaultAlias = 'octovisit_visits_count';

    public function init()
    {
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('visitscount');
    }

    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    public function getLoadValue()
    {
        return $this->model->visits()->count();
    }

    public function getSaveValue($value)
    {
        return $value;
    }
}
