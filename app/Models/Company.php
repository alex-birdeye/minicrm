<?php

namespace App\Models;

use App\Mail\CompanyCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $guarded = [];

    public function save(array $options = [])
    {
        Mail::to($this->email)->send(new CompanyCreated($this->name));
        return parent::save($options);
    }


    public function update(array $attributes = [], array $options = [])
    {
        $this->deleteLogoFile();
        return parent::update($attributes, $options);
    }


    public function delete()
    {
        $this->deleteLogoFile();
        return parent::delete();
    }

    private function deleteLogoFile()
    {
        Storage::disk('public')->delete($this->logo);
    }
}
