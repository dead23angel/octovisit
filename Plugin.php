<?php

namespace CWTeam\OctoVisit;

use Backend;
use CWTeam\OctoVisit\FormWidgets\VisitsCount;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'OctoVisit',
            'description' => 'A plugin to keep track of your pages & understand your audience',
            'author' => 'CWTeam',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * @return string[]
     */
    public function registerFormWidgets(): array
    {
        return [
            VisitsCount::class => 'octovisit_visits_count',
        ];
    }
}
