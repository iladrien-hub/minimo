<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreadCrumb extends Model {
    public $id;
    public $title;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }
}
