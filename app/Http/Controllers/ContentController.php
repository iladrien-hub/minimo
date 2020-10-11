<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{

    private function deleteFile($filename) {
        if (is_file($filename)) {
            unlink($filename);
        }
    }

    private function imageFolder() {
        return public_path('images\\');
    }

    private function saveFile($directory, $file) {
        $fileName = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $fileName);
        return $fileName;
    }

    public function uploadImage(Request $request) {
        $name = $this->saveFile($this->imageFolder(), $request->file('image'));
        DB::table('images')->insert([
            "filename" => $name,
            "uploaded" => now()
        ]);
        return response()->json([
            "filename" => $name
        ], 200);
    }

    public function addPost(Request $request) {
        $imageName =  $this->saveFile($this->imageFolder(), $request->file('post-picture'));
        DB::table('pages')->insert([
            "id" => uniqid(),
            "title" => $request->input('title'),
            "category" => $request->input('category'),
            "short" => $request->input('short'),
            "content" => preg_replace("/style=\".+?\"/", "", $request->input('content')),
            "image" => $imageName,
            "created" => now(),
            "updated" => now()
        ]);
        return redirect()->route('admin');
    }

    public function removePost($id) {
        $item = DB::table('pages')->where("id", $id)->get();
        if (sizeof($item) != 0) {
            $image = $this->imageFolder().$item[0]->image;
            DB::table('pages')->where('id', '=', $id)->delete();
            $this->deleteFile($image);
        }
        return redirect()->route('admin');
    }

    public function updatePost(Request $request) {
        $id = $request->input('id');
        $item = DB::table('pages')->where("id", $id)->get()[0];
        if ($request->hasFile('post-picture')) {
            $this->deleteFile($this->imageFolder().$item->image);
            $imageName =  $this->saveFile($this->imageFolder(), $request->file('post-picture'));
            DB::table('pages')->where('id', $id)->update(['image' => $imageName]);
        }
        DB::table('pages')->where('id', $id)->update([
            "title" => $request->input('title'),
            "category" => $request->input('category'),
            "short" => $request->input('short'),
            "content" => preg_replace("/style=\".+?\"/", "", $request->input('content')),
            "updated" => now()
        ]);
        return redirect()->route('admin');
    }
}
