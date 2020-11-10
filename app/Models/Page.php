<?php

namespace App\Models;

use ArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model {

    public $id, $title, $image, $short, $content, $created, $updated, $isContainer, $sortOrder;
    public $isAlias = false;
    public $aliasId;

    public function __construct($source) {
        if ($source->aliasTo != null) {
            $aliasTarget = DB::table('pages')->where("id", $source->aliasTo)->first();
            $this->id = $source->aliasTo;
            $this->aliasId = $source->id;
            $this->title = $source->title ?? $aliasTarget->title;
            $this->image = $source->image;
            $this->short = $source->short ?? $aliasTarget->short;
            $this->content = $aliasTarget->content;
            $this->created = $aliasTarget->created;
            $this->updated = $aliasTarget->updated;
            $this->isContainer = $aliasTarget->isContainer;
            $this->sortOrder = $aliasTarget->sortOrder;
            $this->isAlias = true;
            return $this;
        }
        $this->id = $source->id;
        $this->title = $source->title;
        $this->image = $source->image;
        $this->short = $source->short;
        $this->content = $source->content;
        $this->created = $source->created;
        $this->updated = $source->updated;
        $this->isContainer = $source->isContainer;
        $this->sortOrder = $source->sortOrder;
        return $this;
    }

    public static function getPages($parentId) {
        $parent = DB::table('pages')->where("id", $parentId)->first();
        $sortOrder = $parent->sortOrder;
        $res = new ArrayObject();
        $children =  DB::table('pages')
            ->where("parent", $parentId)
            ->orderBy($sortOrder, 'desc')
            ->where("id", "!=", "root")
            ->get();
        foreach ($children as $child) {
            $res->append(new Page($child));
        }
        return $res;
    }

}
