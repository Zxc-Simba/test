<?php

namespace App\Models;

use App\Contracts\ModelLabelableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Сайт.
 *
 * @property-read int $id Идентификатор.
 * @property string $name Наименование.
 */
class Site extends Model implements ModelLabelableInterface
{
    /**
     * Ярлыки.
     * @return MorphToMany
     */
    public function labels(): MorphToMany
    {
        return $this->morphToMany(Label::class, 'labelable');
    }
}
