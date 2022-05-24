<?php

namespace App\Models\Base;

use Illuminate\Support\Arr;

/**
 * Class BaseRepository
 */
class BaseRepository
{
    /**
     * Model Class Name.
     *
     * @var string String;
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param array|integer|string|object $model Param.
     */
    public function __construct(array|int|string|object $model)
    {
        $this->model = $model;
    }

    /**
     * Create new Eloquent Query Builder instance
     *
     * @param string $method Param.
     * @param array  $params Param.
     *
     * @return mixed
     */
    public function getQuery(string $method, array $params)
    {
        return call_user_func_array([$this->model, $method], $params);
    }

    /**
     * Create an instance of $this->model::class.
     *
     * @param array $data Param.
     *
     * @return $this->model::class
     */
    public function create(array $data)
    {
        $options = isset($data['options']) ? $data['options'] : [];

        $item = call_user_func_array([$this->model, 'create'], [$data['data'], $options]);

        if (method_exists($this, 'afterCreate')) {
            $this->afterCreate($item, $data);
        }

        return $item;
    }

    /**
     * Update an instance of $this->model::class.
     *
     * @param array $data Param.
     *
     * @return $this->model::class
     */
    public function update(array $data)
    {
        $item = $this->find($data['id']);

        if (method_exists($this, 'beforeUpdateFilter')) {
            $this->beforeUpdateFilter($item, $data);
        }

        if ($item) {
            $options = isset($data['options']) ? $data['options'] : [];

            $item->update($data['data'], $options);

            if (method_exists($this, 'afterUpdate')) {
                $this->afterUpdate($item, $data);
            }
        }

        return $item;
    }

    /**
     * Delete an instance of $this->model::class.
     *
     * @param array $data Param.
     *
     * @return BaseRepository
     */
    public function delete(array $data)
    {
        $object = $this->find($data['id']);

        if ($object) {
            $object->delete();
        }

        if (method_exists($this, 'afterDelete')) {
            $this->afterDelete($object);
        }

        return $object;
    }

    /**
     * Find an instance of $this->model::class.
     *
     * @param integer $id     Param.
     * @param array   $params Param.
     *
     * @return $this->model::class
     */
    public function find(int $id, array $params = [])
    {
        $query = null;

        if (isset($params['with']) && is_array($params['with']) && \count($params['with'])) {
            $query = \call_user_func_array([$this->model, 'with'], [$params['with']]);
        }

        if (isset($params['withCount']) && is_array($params['withCount']) && \count($params['withCount'])) {
            $query = \call_user_func_array([$this->model, 'withCount'], [$params['withCount']]);
        }

        if (isset($params['inputs'])) {
            $wheres = [];
            $inputs = array_filter((array)$params['inputs']);

            foreach ($inputs as $key => $val) {
                $permittedInputs = (new $this->model())->searchable;
                if ((is_numeric($key) && \is_array($val)) || \in_array(
                    $key,
                    $permittedInputs,
                    true
                )) {
                    $wheres[$key] = $val;
                }
            }

            if ($wheres) {
                $query = call_user_func_array([$query ?: $this->model, 'where'], [$wheres]);
            }
        }

        if (isset($params['wheres'])) {
            foreach ($params['wheres'] as $where) {
                $query = call_user_func_array([
                    $query ?: $this->model, $where['method']
                ], $where['args']);
            }
        }

        if (isset($params['havings'])) {
            foreach ($params['havings'] as $having) {
                $query = call_user_func_array([
                    $query ?: $this->model,
                    $having['method']
                ], $having['args']);
            }
        }

        if (isset($params['columns'])) {
            $columns = array_filter(\is_array($params['columns']) ?
                $params['columns'] : explode(',', $params['columns']));
            $query = call_user_func_array([$query ?: $this->model, 'select'], $columns);
        }

        if (isset($params['inputs']['with'])) {
            $inputWiths = \is_array($params['inputs']['with']) ?
                $params['inputs']['with'] : explode(',', $params['inputs']['with']);
            $query = call_user_func_array([$query ?: $this->model, 'with'], [$inputWiths]);
        }

        if (isset($params['inputs']['columns'])) {
            $inputColumns = explode(',', $params['inputs']['columns']);
            $query = call_user_func_array([$query ?: $this->model, 'select'], [$inputColumns]);
        }

        if (isset($params['scopes'])) {
            foreach ($params['scopes'] as $scope) {
                $query = call_user_func_array([$query ?: $this->model, $scope], []);
            }
        }

        return call_user_func_array([$query ?: $this->model, 'find'], [$id]);
    }

    /**
     * @param array $params Param.
     *
     * @return array|mixed
     */
    public function getAll(array $params = [])
    {
        $query = null;

        if (isset($params['wheres'])) {
            foreach ($params['wheres'] as $where) {
                $query = call_user_func_array(
                    [$query ?: $this->model, $where['method']],
                    $where['args']
                );
            }
        }

        if ($query && method_exists($this, 'addWhereToGetAll')) {
            $query = $this->addWhereToGetAll($query, $params);
        }

        if (method_exists($this, 'addAdvancedSearchToGetAll')) {
            $query = $this->addAdvancedSearchToGetAll($query, $params);
        }

        $page = (int)(Arr::get($params['inputs'], 'page'));
        $perpage = Arr::get($params['inputs'], 'perpage');

        if (isset($params['with']) && is_array($params['with']) && \count($params['with'])) {
            $query = call_user_func_array([$query ?: $this->model, 'with'], [$params['with']]);
        }

        if (isset($params['inputs']['with'])) {
            $inputWiths = \is_array($params['inputs']['with']) ?
                $params['inputs']['with'] : explode(',', $params['inputs']['with']);
            $query = call_user_func_array([$query ?: $this->model, 'with'], [$inputWiths]);
        }

        if (isset($params['inputs']['columns'])) {
            $inputColumns = \is_array($params['inputs']['columns']) ?
                $params['inputs']['columns'] : explode(',', $params['inputs']['columns']);
            $query = call_user_func_array([$query ?: $this->model, 'select'], [$inputColumns]);
        }

        $orderby = isset($params['inputs']['orderby']) ?
            $params['inputs']['orderby'] : 'created_at';
        $order = isset($params['inputs']['order']) ? $params['inputs']['order'] : 'desc';
        $query = call_user_func_array([$query ?: $this->model, 'orderby'], [$orderby, $order]);
        $query = call_user_func_array([$query ?: $this->model, 'orderby'], ['id', 'desc']);

        if ($page < 0) {
            $result = call_user_func_array([$query ?: $this->model, 'get'], []);
        } else {
            $result = $this->result_for_paginate(call_user_func_array([$query ?: $this->model, 'paginate'], [$perpage]));
        }

        return $result;
    }

    /**
     * @param array|integer|string|object $collection Param.
     *
     * @return array
     */
    private function result_for_paginate(array|int|string|object  $collection)
    {
        return [
            'items'   => $collection->items(),
            'page'    => $collection->currentPage(),
            'total'   => $collection->total(),
            'pages'   => $collection->lastPage(),
            'perPage' => $collection->perPage(),
        ];
    }
}
