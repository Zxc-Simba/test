<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Ярлык.
 *
 * @property-read int $id Идентификатор.
 * @property-read int $name Наименование ярлыка.
 */
class Label extends Model
{
    /**
     * Компании с ярлыком.
     * @return MorphToMany
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'labelable');
    }

    /**
     * Сайты с ярлыком.
     * @return MorphToMany
     */
    public function sites(): MorphToMany
    {
        return $this->morphedByMany(Site::class, 'labelable');
    }

    /**
     * Пользователи с ярлыком.
     * @return MorphToMany
     */
    public function clients(): MorphToMany
    {
        return $this->morphedByMany(Client::class, 'labelable');
    }
}
