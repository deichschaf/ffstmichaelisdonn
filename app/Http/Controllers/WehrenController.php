<?php

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Traits\WehrenTrait;

class WehrenController extends GroundController
{
    public function adminShow()
    {
        $data = WehrenTrait::getAll();
    }

    public function savedata()
    {
    }
    public function add()
    {
    }
    public function edit($id)
    {
    }
    public function delete($id)
    {
    }
    public function delete_save()
    {
    }
}
