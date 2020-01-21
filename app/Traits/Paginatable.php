<?php

namespace App\Traits;

trait Paginatable
{
    private $pageSizeLimit = 100;

    public function getPerPage(){
        $pageSize = request('page_size', $this->perPage);

        return min($pageSize, $this->pageSizeLimit);
    }
}