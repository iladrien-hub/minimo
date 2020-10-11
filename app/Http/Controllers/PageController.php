<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArrayObject;
use App\Models\Page;

class PageController extends Controller
{
    private function getContentCategories() {
        return DB::table('category')->get();
    }

    private function getPagesArray() {
        $res = new ArrayObject();
        $resp = DB::table('pages')->orderBy('updated', 'desc')->get();
        foreach ($resp as $page) {
            $res->append(new Page(
                $page->id,
                $page->title,
                $page->category,
                $page->short,
                $page->content,
                $page->image,
                $page->created,
                $page->updated
            ));
        }
        return $res;
    }

    private function getPage($id) {
        $resp =  DB::table('pages')->where("id", $id)->get();
        if (sizeof($resp) < 1) {
            return "404 Page not found";
        }
        $post = new Page(
            $resp[0]->id,
            $resp[0]->title,
            $resp[0]->category,
            $resp[0]->short,
            $resp[0]->content,
            $resp[0]->image,
            $resp[0]->created,
            $resp[0]->updated
        );
        return $post;
    }

    public function homepage() {
        return view('homepage', [
            'categories' => $this->getContentCategories(),
            'pages' => $this->getPagesArray()
        ]);
    }

    public function newpost() {
        return view('creator', [
            'categories' => $this->getContentCategories(),
            'pictures' => DB::table('images')->get()
        ]);
    }

    public function update($id) {
        return view('update', [
            'categories' => $this->getContentCategories(),
            'pictures' => DB::table('images')->get(),
            'post' => $this->getPage($id)
        ]);
    }

    public function post($id) {
        return view('post', [
            'categories' => $this->getContentCategories(),
            'post' => $this->getPage($id)
        ]);
    }

    public function adminPanel() {
        return view('admin', [
            'categories' => $this->getContentCategories(),
            'pages' => $this->getPagesArray()
        ]);
    }

}
