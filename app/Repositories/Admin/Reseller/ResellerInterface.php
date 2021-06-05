<?php

namespace App\Repositories\Admin\Reseller;

interface ResellerInterface
{
    public function getPaginatedList($request, int $per_page = 5);
    public function getShow(int $id);
    public function postStore($request);
    public function postUpdate($request, int $id);
    public function delete($id);
}
