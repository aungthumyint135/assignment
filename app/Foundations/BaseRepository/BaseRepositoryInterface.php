<?php

namespace App\Foundations\BaseRepository;

interface BaseRepositoryInterface
{
    public function all(array $options = []);

    public function getDataById(int $id, array $relations = []);

    public function getDataByUuid($uuid, array $relations = []);

    public function insert(array $data);

    public function update(array $data, int $id);

    public function getDataByOptions(array $options = []);

    public function destroy(int $id);

    public function totalCount(array $options = []);

}
