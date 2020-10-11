<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model {

    public $id;
    public $title;
    public $category;
    public $category_name;
    public $short;
    public $content;
    public $image;
    public $created;
    public $updated;

    public function __construct($id, $title, $category, $short,
        $content, $image, $created, $updated) {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->short = $short;
        $this->content = $content;
        $this->image = $image;
        $this->created = $created;
        $this->created = $created;
        $this->updated = $updated;
        $this->category_name = DB::table('category')->where("id", $category)->get()->first()->name;
    }
}
