<p align="center">
    <img src="logo.png" alt="Octovisit Logo" width="300">
    <br><br>
</p>

A clean way to track your pages & understand your user's behavior. This implement [laravisit](https://github.com/coderflexx/laravisit) to OctoberCMS.

## Requirements

- October CMS 3.0 or above

## Installation Instructions

Run the following to install this plugin:

```bash
php artisan plugin:install CWTeam.OctoVisit
```

To uninstall this plugin:

```bash
php artisan plugin:remove CWTeam.OctoVisit
```

then, run database migration
```bash
php artisan october:migrate
```


## Usage

Then implement the **CWTeam\OctoVisit\Behaviors\VisitModel** behavior in the model class:

```php
namespace Acme\Demo\Models\Post;

use CWTeam\OctoVisit\Behaviors\VisitModel;

class Post extends Model
{
    ...
    public $implement = [
        VisitModel::class,
    ];
    ...
}
```
After this step, you are all set, you can now count visits by using `visit` method, but please keep in mind that the method returns an instance of the CWTeam\OctoVisit\PendingVisit class.

```php
$post->visit();
```

You can chain methods to the `visit` method. Here are a list of the available methods:

| METHOD      | SYNTAX      | DESCRIPTION                                      | EXAMPLE     |
| ----------- | ----------- |--------------------------------------------------| ----------- |
| `withIp()`      | string `$ip = null`       | Set an Ip address (default `request()->ip()`)    | `$post->visit()->withIp()`       |
| `withSession()` | string `$session = null` | Set an Session ID (default `session()->getId()`) | `$post->visit()->withSession()` |
|`withData()` | array `$data` | Set custom data                                  | `$post->visit()->withData(['region' => 'USA'])` |
| `withUser()` | Model `$user = null` | Set a user model (default `Auth::getUser()`)     | `$user->visit()->withUser()` |

---

By default, you will have unique visits __each day__ using `dailyInterval()` method. Meaning, when the users access the page multiple times in a day time frame, you will see just `one record` related to them.

If you want to log users access to a page with different __timeframes__, here are a bunch of useful methods:

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `hourlyInterval()` | `void` | Log visits each hour | `$post->visit()->hourlyIntervals()->withIp();` |
| `dailyInterval()` | `void` | Log visits each day | `$post->visit()->dailyIntervals()->withIp();` |
| `weeklyInterval()` | `void` | Log visits each week | `$post->visit()->weeklyIntervals()->withIp();` |
| `monthlyInterval()` | `void` | Log visits each month | `$post->visit()->monthlyIntervals()->withIp();` |
| `yearlyInterval()` | `void` | Log visits each year | `$post->visit()->yearlyIntervals()->withIp();` |
| `customInterval()` | mixed `$interval` | Log visits within a custom interval | `$post->visit()->customInterval( now()->subYear() )->withIp();` |

### Get The Records With Popular Time Frames
After the visits get logged, you can retrieve the data by the following method:

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `withTotalVisitCount()` | `void` | get total visit count | `Post::withTotalVisitCount()->first()->visit_count_total` |
| `popularAllTime()` | `void` | get popular visits all time | `Post::popularAllTime()->get()` |
| `popularToday()` | `void` | get popular visits in the current day | `Post::popularToday()->get()` |
| `popularLastDays()` | int `$days` | get popular visits last given days | `Post::popularLastDays(10)->get()` |
| `popularThisWeek()` | `void` | get popular visits this week | `Post::popularThisWeek()->get()` |
| `popularLastWeek()` | `void` | get popular visits last week | `Post::popularLastWeek()->get()` |
| `popularThisMonth()` | `void` | get popular visits this month | `Post::popularThisMonth()->get()` |
| `popularLastMonth()` | `void` | get popular visits last month | `Post::popularLastMonth()->get()` |
| `popularThisYear()` | `void` | get popular visits this year | `Post::popularThisYear()->get()` |
| `popularLastYear()` | `void` | get popular visits last year | `Post::popularLastYear()->get()` |
| `popularBetween()` | Carbon `$from`, Carbon `$to` | get popular visits between custom two dates | `Post::popularBetween(Carbon::createFromDate(2019, 1, 9), Carbon::createFromDat(2022, 1, 3))->get();` |

## Visit Presenter
This package is coming with helpful decorate model properties, and it uses [Laravel Presenter](https://github.com/coderflexx/laravel-presenter) package under the hood.

| METHOD      | SYNTAX      | DESCRIPTION | EXAMPLE     |
| ----------- | ----------- | ----------- | ----------- |
| `ip()` | `void` | Get the associated IP from the model instance | `$post->visits->first()->present()->ip`|
| `user()` | `void` | Get the associated User from the model instance | `$post->visits->first()->present()->user->name`|

## View count visits in Backend

1. View in list. Add to columns.yaml
```yaml
    visits_count:
        label: Visits count
        relation: visits
        relationCount: true
        type: number
```

2. View in form. Add in fields.yaml
```yaml
    visits:
        label: Count visits
        type: octovisit_visits_count
        context: [preview, update]
        readOnly: true
```

## View list visitors in form Backend
1. Add in fields.yaml
```yaml
    visitors:
        label: List of visitors
        type: partial
        context: [ preview, update ]
        readOnly: true
```

2. Create view _visitors.htm in folder with controller config
```html
<table class="table">
    <thead>
    <tr>
        <th>User id</th>
        <th>User email</th>
        <th>IP</th>
        <th>Date visit</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($formModel->visits as $visit) { ?>
    <tr>
        <td><?= $visit->present()->user()->id ?? '-' ?></td>
        <td><?= $visit->present()->user()->email ?? '-' ?></td>
        <td><?= $visit->present()->ip() ?></td>
        <td><?= $visit->created_at ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Ivan Gorokhov](https://github.com/dead23angel)
- [Oussama Sid](https://github.com/ousid)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
