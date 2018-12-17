<?php

namespace App\Models\Presenters;

use Laracasts\Presenter\Presenter;
use App\Traits\FormatsPresenterTimestamps;
use Config;

class UserPresenter extends Presenter
{
    use FormatsPresenterTimestamps;

    /**
     * Get avatar
     *
     * @return string
     */
    public function avatar(): string
    {
        return $this->avatar_url ?? Config::get('app.default_avatar');
    }
}
