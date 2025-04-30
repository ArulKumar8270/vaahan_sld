<?php

namespace App\Traits;
use Request;
use Illuminate\Support\Facades\Storage;
use Arr;
use Str;

trait ToolsTrait
{
    public function checkFillable($input) {
        $output = [];
        if($input && is_array($input) && count($input) > 0) {
            $output = array_intersect_key($input, array_flip($this->model->getFillable()));
        }
        return $output;
    }

    /**
     * Returns all records.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($input = null) {
        $count = 2000;
        $items = $this->index($input)
                        ->GetData($count, $input);
        $data = $this->collectionItemsWithAppends($items, $input);
        $paginate = @$input['paginate'] ?: null;
        $page = @$input['page'] ?: null;
        if($paginate && $page) { $items->data = $data; }
        else { $items = $data; }
        return $items;
    }

    /**
     * Stores record into database.
     * @param array $input
     * @return Service
     */
    public function store($input) {
        // $input = $this->checkFillable($input);
        // dd($input);
        return $this->model->create($this->arrayFilter($input));
    }

    /**
     * Find the record by given id.
     * @param int $id
     * @return \Illuminate\Support\Collection|null|static|Service
     */
    public function findById($id, $input = []) {
        $item = $this->model
                ->IncludeFilter($input)
                ->find($id);
        $item = $this->collectionItemWithAppends($item);
        return $item;
    }

    public function findByName($name, $input = []) {
        $slug = Str::slug($name, '-');
        $item = $this->model->where('slug', '=', $slug)->IncludeFilter($input)->first()->SetAppendByRequest($input);
        return ($item && $item->id) ? $item : null;
    }

    public function findBySlug($slug, $input = []) {
        $slug = Str::slug($slug, '-');
        $item = $this->model->where('slug', '=', $slug)->IncludeFilter($input)->first();
        return ($item && $item->id) ? $item : null;
    }

    public function findByColumn($columnName, $columnValue, $input = []) {
        $input[$columnName] = $columnValue;
        $item = $this->model->where($columnName, '=', $columnValue)->first();
        return ($item && $item->id) ? $item : null;
    }

    /**
     * Updates the record into database.
     * @param id   $id
     * @param array $input
     * @return the record
     */
    public function update($id, $input) {
        $item = $this->model->find($id);
        // $input = $this->checkFillable($input);
        $item->fill($this->arrayFilter($input));
        $item->save();
        return $item;
    }

    /**
     * Get unused activities for services
     * @param $id
     * @return the record
     */
    public function destroy($id, $isForced = false) {
        $item = $this->model->find($id);
        if($item && $item->id) {
            if($isForced) { $item->forceDelete(); }
            else { $item->delete(); }
        } else {
            throw new \Exception('No Records Found', 405);
        }
        return;
    }

    public function forceDestroy($id) {
        $item = $this->model->find($id);
        if($item && $item->id) {
            $item->forceDelete();
        } else {
            throw new \Exception('No Records Found', 405);
        }
        return;
    }

    /**
     * Get unused activities for services
     * @param $id
     * @return the record
     */
    public function multiDestroy($idsArray, $isForced = false) {
        if(!is_array($idsArray)) {
            throw new ErrorResponse('Unsupported Data: Required Integers Array as an input',405,'info');
        }
        if($isForced) {
            $items = $this->model->find($idsArray)->forceDelete();
        } else {
            $items = $this->model->find($idsArray)->delete();
        }
        return;
    }

    public function collectionItemsWithAppends($collection, $input) {
        $appends = Arr::has($input, 'appends') ? $input['appends'] : null;
        $all = Arr::has($input, 'all') ? $input['all'] : null;
        $appendsArray = (!is_null($appends)) ? $this->model->SetAppendByRequest($input)->getAppends() : null;
        if($appends && $appendsArray && count($appendsArray) > 0 && $all && $all > 0) {
            return $collection->each(function ($item) use ($appendsArray) {
                $item->setAppends($appendsArray);
            });
        }
        if($appends && $appendsArray && count($appendsArray) > 0 && is_null($all)) {
            return $collection->getCollection()->each(function ($item) use ($appendsArray) {
                $item->setAppends($appendsArray);
            });
        }
        return $collection;
    }

    public function collectionItemWithAppends($collection) {
        $input = Request::all();
        $appends = Arr::has($input, 'appends') ? $input['appends'] : null;
        $appendsArray = (!is_null($appends)) ? $this->model->SetAppendByRequest($input)->getAppends() : null;
        if($appends && $appendsArray && count($appendsArray) > 0 && $collection && $collection->id) {
            $collection = $collection->setAppends($appendsArray);
        }
        return $collection;
    }

    public function arrayFilter($input) {
        $output = array_filter($input, fn ($value) =>
            !(is_null($value) && empty(trim($value)))
        );
        return $output;
    }
}