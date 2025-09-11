<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\{
    Collection,
    Model,
};

class BaseRepository implements BaseInterface
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected Model $model;

    /**
     * Constructor for initializing the BaseRepository.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of model instances.
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a record by ID. Fails if none found.
     *
     * @param int $id The ID of the record.
     *
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param array<mixed> $data The data for the new record.
     *
     * @return \Illuminate\Database\Eloquent\Model The created model instance.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record.
     *
     * @param int $id The ID of the record to update.
     * @param array<mixed> $data The updated data.
     *
     * @return \Illuminate\Database\Eloquent\Model The updated model instance.
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);

        return $record;
    }

    /**
     * Delete a record by ID.
     *
     * @param int|array<mixed> $ids The ID or an array of IDs to delete.
     *
     * @return bool True if at least one record was deleted, false otherwise.
     */
    public function delete(int|array $ids): ?bool
    {
        return $this->model->destroy($ids) > 0;
    }
}
