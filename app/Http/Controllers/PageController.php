<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArrayObject;
use App\Models\Page;
use App\Models\BreadCrumb;

class PageController extends Controller
{
    private function getContentCategories() {
        return DB::table('pages')->where("parent", "root")->where("id", "!=", "root")->get();
    }

    private function getBreadCrumbs($id) {
        $res = new ArrayObject();
        while ($id !== "root") {
            $item = DB::table('pages')->where("id", $id)->get()[0];
            $res->append(new BreadCrumb($id, $item->title));
            $id = $item->parent;
        }
        return array_reverse($res->getArrayCopy());
    }

    private function getPagesArray($parent) {
        $parent = DB::table('pages')->where("id", $parent)->get();
        if (sizeof($parent) > 0){
            $parent = $parent[0];
            $resp = DB::table('pages')->
                where("parent", $parent->id)->orderBy($parent->sortOrder, 'desc')->
                where("id", "!=", "root")->get();
            return $resp;
        }
        return new ArrayObject();
    }

    private function getPage($id) {
        $resp =  DB::table('pages')->where("id", $id)->get();
        if (sizeof($resp) < 1) {
            return "404 Page not found";
        }
        return $resp[0];
    }

    private function getPageParent($id) {
        $parent = DB::table('pages')->where("id", $id)->get();
        if ( sizeof($parent) != 0 ) {
            return DB::table('pages')->where("id", $parent[0]->parent)->get()[0];
        }
        return NULL;
    }

    public function homepage() {
        return view('homepage', [
            'categories' => $this->getContentCategories(),
            'pages' => $resp = DB::table('pages')->where("isContainer", "false")->orderBy("updated", "desc")->get()
        ]);
    }

    public function newpost($id) {
        return view('creator', [
            'categories' => $this->getContentCategories(),
            'pictures' => DB::table('images')->get(),
            'parent' => $id
        ]);
    }

    public function update($id) {
        return view('update', [
            'categories' => $this->getContentCategories(),
            'pictures' => DB::table('images')->get(),
            'post' => $this->getPage($id)
        ]);
    }

    public function page($id) {
        $page = $this->getPage($id);
        if ($page->isContainer) {
            return view('container', [
                'categories' => $this->getContentCategories(),
                'childs' =>  DB::table('pages')->
                                where("isContainer", "1")->
                                where("parent", $id)->get(),
                'articles' =>  DB::table('pages')->
                                where("isContainer", "0")->
                                where("parent", $id)->
                                orderBy($page->sortOrder)->get(),
                'breadCrumbs' => $this->getBreadCrumbs($id),
                'page' => $page
            ]);
        }
        return view('post', [
            'categories' => $this->getContentCategories(),
            'breadCrumbs' => $this->getBreadCrumbs($id),
            'post' => $page
        ]);
    }

    public function adminPanel($dir) {
        return view('admin', [
            'categories' => $this->getContentCategories(),
            'pages' => $this->getPagesArray($dir),
            'dir' => $dir,
            'parent' => $this->getPageParent($dir),
            'breadCrumbs' => $this->getBreadCrumbs($dir)
        ]);
    }

}
