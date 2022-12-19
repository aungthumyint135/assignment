<?php

namespace App\Foundations\BaseRepository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @param array $options
     * @return Builder
     */
    protected function optionsQuery(array $options)
    {
        $query = $this->connection()->query();

        if (isset($options['limit'])) {
            $query = $query->limit($options['limit']);
        }

        if (isset($options['offset'])) {
            $query = $query->offset($options['offset']);
        }

        if (isset($options['order_by'])) {
            if (is_array($options['order_by'])) {
                foreach ($options['order_by'] as $column => $orderBy) {
                    $query = $query->orderBy($column, $orderBy);
                }
            } else {
                $query = $query->orderBy('created_at', $options['order_by']);
            }
        } else {
            $query = $query->orderBy('created_at', 'desc');
        }

        if (isset($options['with'])) {
            $query = $query->with($options['with']);
        }

        if (isset($options['only'])) {
            $query = $query->select($options['only']);
        }

        if (isset($options['id'])) {
            $query = $query->where('id', '=', $options['id']);
        }

        if (!empty($options['uuid'])) {
            $query = $query->where('uuid', '=', $options['uuid']);
        }

        return $query;
    }

    /**
     * @param array $options
     * @return Builder[]|Collection
     */
    public function all(array $options = [])
    {
        return $this->optionsQuery($options)->get();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Builder|Model|object|null
     */
    public function getDataById(int $id, array $relations = [])
    {
        return $this->connection()->query()->with($relations)->where('id', $id)->first();
    }

    /**
     * @param $uuid
     * @param array $relations
     * @return Builder|Model|object|null
     */
    public function getDataByUuid($uuid, array $relations = [])
    {
        return $this->connection()->query()->with($relations)->where('uuid', $uuid)->first();
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function insert(array $data)
    {
        return $this->connection()->query()->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update(array $data, int $id)
    {
        return $this->connection()->query()->where('id', $id)->update($data);
    }

    /**
     * @param array $options
     * @retu\Illuminate\Database\Eloquent\rn Builder|Model|object|null
     */
    public function getDataByOptions(array $options = [])
    {
        return $this->optionsQuery($options)->first();
    }

    /**
     * @param int $id
     * @return bool|mixed|null
     */
    public function destroy(int $id)
    {
        return $this->connection()->query()->find($id)->delete();
    }

    /**
     * @param array $options
     * @return int
     */
    public function totalCount(array $options = [])
    {
        return $this->optionsQuery($options)->count();
    }

    /**
     * @return Model
     */
    abstract public function connection(): Model;

}
