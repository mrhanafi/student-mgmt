<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable{
    public string $search = '';

    public function applySearch(Builder $query)
    {
        return $query->where('name','like','%'.$this->search.'%')
        ->orWhere('email','like','%'.$this->search.'%')
        ->orWhereHas('class',function($query){
            $query->where('name','like','%'.$this->search.'%');
        });
    }
}