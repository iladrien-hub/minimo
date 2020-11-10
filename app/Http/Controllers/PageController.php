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
            'pages' => DB::table('pages')->
                where("isContainer", "false")->
                where("aliasTo", null)->
                orderBy("updated", "desc")->
                get()
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
                'subDirectories' =>  Page::getPages($id),
                'articles' => Page::getPages($id),
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
            'pages' => Page::getPages($dir),
            'dir' => $dir,
            'parent' => $this->getPageParent($dir),
            'breadCrumbs' => $this->getBreadCrumbs($dir)
        ]);
    }

    public function getPagesLike(Request $request) {
        $pages = DB::table('pages')->
            where('title', 'LIKE', $request->input('title').'%')->
            where("isContainer", "==", false)->
            get();
        $res = new ArrayObject();
        foreach ($pages as $page) {
            if ($page->aliasTo != null)
                continue;
            $res->append( [ "title" => $page->title, "id" => $page->id ] );
        }
        return response()->json(["pages" =>$res ], 200);
    }
}
