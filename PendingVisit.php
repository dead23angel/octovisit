<?php

namespace Dead23Angel\OctoVisit;

use Dead23Angel\OctoVisit\Behaviors\VisitModel;
use Dead23Angel\OctoVisit\Exceptions\InvalidDataException;
use Dead23Angel\OctoVisit\Exceptions\VisitException;
use Dead23Angel\OctoVisit\Models\Visit;
use Dead23Angel\OctoVisit\Traits\SetsPendingIntervals;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Model;
use RainLab\User\Facades\Auth;

class PendingVisit
{
    use SetsPendingIntervals;

    /**
     * @var array
     *
     */
    protected array $attributes = [];

    public bool $isCrawler = false;

    /**
     * @param Model $model
     * @throws VisitException
     */
    public function __construct(protected Model $model)
    {
        if (!in_array(VisitModel::class, $model->implement, false)) {
            throw VisitException::interfaceNotImplemented($model);
        }

        $crawlerDetect = new CrawlerDetect(null, request()->header('User-Agent'));

        $this->isCrawler = $crawlerDetect->isCrawler();

        // set daily intervals by default
        $this->dailyIntervals();
    }

    /**
     * Set IP attribute
     *
     * @param string|null $ip
     * @return self
     */
    public function withIP(string $ip = null): self
    {
        $this->attributes['ip'] = $ip ?? request()->ip();

        return $this;
    }

    /**
     * Set Session attribute
     *
     * @param string|null $session
     * @return self
     */
    public function withSession(string $session = null): self
    {
        $this->attributes['session'] = $session ?? session()->getId();

        return $this;
    }

    /**
     * Set Custom Data attribute
     *
     * @param array $data
     * @return self
     * @throws InvalidDataException
     */
    public function withData(array $data): self
    {
        if (!count($data)) {
            throw new InvalidDataException('The data argument cannot be empty');
        }

        $this->attributes = array_merge($this->attributes, $data);

        return $this;
    }

    /**
     * Set User attribute
     *
     * @param Model|null $user
     * @return self
     */
    public function withUser(Model $user = null): self
    {
        $this->attributes['user_id'] = $user?->id ?? Auth::id();

        return $this;
    }

    /**
     * Build Json Columns from the given attribues
     *
     * @return array
     */
    protected function buildJsonColumns(): array
    {
        return collect($this->attributes)
            ->mapWithKeys(
                fn($value, $index) => ['data->' . $index => $value]
            )
            ->toArray();
    }

    /**
     * Make sure that we need to log the current record or not
     * based on the creation
     *
     * @param Visit $visit
     * @return bool
     */
    protected function shouldBeLoggedAgain(Visit $visit): bool
    {
        return !$visit->wasRecentlyCreated &&
            $visit->created_at->lt($this->interval);
    }

    public function __destruct()
    {
        if ($this->isCrawler) {
            return;
        }

        $visit = $this->model
            ->visits()
            ->latest()
            ->firstOrCreate($this->buildJsonColumns(), [
                'data' => $this->attributes,
            ]);

        $visit->when(
            $this->shouldBeLoggedAgain($visit),
            function () use ($visit) {
                $visit->replicate()->save();
            }
        );
    }
}
