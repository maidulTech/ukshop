<?php

namespace App\Repositories\Admin\Faulty;

interface FaultyInterface
{
    public function findOrThrowException($type,$id);
    public function ajaxFaultyChecker($type,$id,$faulty_type);
}
