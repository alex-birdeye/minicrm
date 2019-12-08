<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $guarded = [];

    public function delete()
    {
        Storage::disk('public')->delete($this->logo);
        return parent::delete();
    }


}
