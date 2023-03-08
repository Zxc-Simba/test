<?php

namespace App\Contracts;


use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface ModelLabelableInterface
{
    /**
     * Ярлыки.
     * @return MorphToMany
     */
    public function labels(): MorphToMany;
}
