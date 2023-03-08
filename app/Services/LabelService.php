<?php

namespace App\Services;

use App\Contracts\ModelLabelableInterface;
use App\Exceptions\EmptyLabelCollectionException;
use App\Exceptions\UndefinedLabelsException;
use App\Models\Label;
use App\Models\Site;
use Illuminate\Support\Collection;

/**
 * Сервис-репозиторий ярлыков.
 */
class LabelService
{
    /**
     * Тестовый метод.
     *
     * @return void
     * @throws UndefinedLabelsException
     * @throws EmptyLabelCollectionException
     */
    public function test(): void
    {
        // Entity //
//        $entity = Company::find(1);
        $entity = Site::find(1);
//        $entity = Client::find(1);
        // Add labels
        $labels = Label::whereIn('id', [1, 2, 3, 4])->get();
//        $labels = Label::whereIn('id', [1, 2, 3, 4])->get()->add(['id' => 10, 'name' => 'Несущ. ярлык']); // App\Exceptions\UndefinedLabelsException
//        $labels = Label::whereIn('id', [])->get(); // App\Exceptions\EmptyLabelCollectionException
        $this->addLabels($entity::class, $entity->id, $labels);
        // Rewrite labels
//        $labels = Label::whereIn('id', [])->get();
//        $labels = Label::whereIn('id', [1, 3, 4, 5])->get();
//        $labels = Label::whereIn('id', [1, 3, 4, 5])->get()->add(['id' => 10, 'name' => 'Несущ. ярлык']); // App\Exceptions\UndefinedLabelsException
//        $this->rewriteLabels($entity::class, $entity->id, $labels);
        // Remove labels
//        $labels = Label::whereIn('id', [1, 5])->get();
//        $labels = Label::whereIn('id', [])->get(); // App\Exceptions\EmptyLabelCollectionException
//        $labels = Label::whereIn('id', [1, 5])->get()->add(['id' => 10, 'name' => 'Несущ. ярлык']); // App\Exceptions\UndefinedLabelsException
//        $this->removeLabels($entity::class, $entity->id, $labels);
        // Get labels
//        $labels = $this->getLabels($entity::class, $entity->id);
    }

    /**
     * Метод 1. Перезаписать ярлыки сущности.
     *
     * @param string $modelType Тип сущности.
     * @param int $modelId Идентификатор сущности.
     * @param Collection $labels Ярлыки.
     * @return void
     * @throws UndefinedLabelsException
     */
    public function rewriteLabels(string $modelType, int $modelId, Collection $labels): void
    {
        $unexistingLabels = $this->getUnexistingLabels($labels);
        if (!$unexistingLabels->isEmpty()) {
            throw new UndefinedLabelsException($unexistingLabels);
        }
        /** @var ModelLabelableInterface $modelRecord */
        $modelRecord = $modelType::find($modelId);
        $labelsIds = $labels->pluck('id')->toArray();
        $modelRecord->labels()->sync($labelsIds);
    }

    /**
     * Метод 2. Добавить ярлыки сущности.
     *
     * @param string $modelType Тип сущности.
     * @param int $modelId Идентификатор сущности.
     * @param Collection $labels Ярлыки.
     * @return void
     * @throws UndefinedLabelsException
     * @throws EmptyLabelCollectionException
     */
    public function addLabels(string $modelType, int $modelId, Collection $labels): void
    {
        if ($labels->isEmpty()) {
            throw new EmptyLabelCollectionException();
        }
        $unexistingLabels = $this->getUnexistingLabels($labels);
        if (!$unexistingLabels->isEmpty()) {
            throw new UndefinedLabelsException($unexistingLabels);
        }
        /** @var ModelLabelableInterface $modelRecord */
        $modelRecord = $modelType::find($modelId);
        $labelsIds = $labels->pluck('id')->toArray();
        $modelRecord->labels()->syncWithoutDetaching($labelsIds);
    }

    /**
     * Метод 2_1. Добавить ярлыки сущности.
     *
     * @param ModelLabelableInterface $modelLabelable Ярлыкуемая модель.
     * @param Collection $labels Ярлыки.
     * @return void
     * @throws UndefinedLabelsException
     */
    public function addLabelsSecondImpl(ModelLabelableInterface $modelLabelable, Collection $labels): void
    {
        $unexistingLabels = $this->getUnexistingLabels($labels);
        if (!$unexistingLabels->isEmpty()) {
            throw new UndefinedLabelsException($unexistingLabels);
        }
        $modelLabelable->labels()->sync($labels->pluck('id')->toArray());
    }

    /**
     * Метод 3. Удалить ярлыки сущности.
     *
     * @param string $modelType Тип сущности.
     * @param int $modelId Идентификатор сущности.
     * @param Collection $labels Ярлыки.
     * @return void
     * @throws EmptyLabelCollectionException
     * @throws UndefinedLabelsException
     */
    public function removeLabels(string $modelType, int $modelId, Collection $labels): void
    {
        if ($labels->isEmpty()) {
            throw new EmptyLabelCollectionException();
        }
        $unexistingLabels = $this->getUnexistingLabels($labels);
        if (!$unexistingLabels->isEmpty()) {
            throw new UndefinedLabelsException($unexistingLabels);
        }
        /** @var ModelLabelableInterface $modelRecord */
        $modelRecord = $modelType::find($modelId);
        $labelsIds = $labels->pluck('id')->toArray();
        $modelRecord->labels()->whereIn('labels.id', $labelsIds)->delete();
    }

    /**
     * Метод 4. Получение ярлыков сущности.
     *
     * @param string $modelType Тип сущности.
     * @param int $modelId Идентификатор сущности.
     * @return Collection
     */
    public function getLabels(string $modelType, int $modelId): Collection
    {
        $modelRecord = $modelType::find($modelId);
        return $modelRecord->labels;
    }

    /**
     * Получить несуществующие в базе данных ярлыки.
     *
     * @param Collection $labels Ярлыки.
     * @return Collection
     */
    private function getUnexistingLabels(Collection $labels): Collection
    {
        $unexistingLabels = [];
        foreach ($labels as $label) {
            $labelRecord = Label::find($label->id);
            if (is_null($labelRecord)) {
                $unexistingLabels[] = $label;
            }
        }
        return collect($unexistingLabels);
    }
}
