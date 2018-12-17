<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatsPresenterTimestamps
{
    /**
     * Retorna a data formatada
     *
     * @return string
     */
    public function createdAt(): string
    {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i:s');
    }

    /**
     * Retorna a data formatada
     *
     * @return string
     */
    public function updatedAt(): string
    {
        return Carbon::parse($this->updated_at)->format('d/m/Y H:i:s');
    }
}
