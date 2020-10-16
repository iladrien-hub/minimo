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

    private function dropPages($id) {
        $item = DB::table('pages')->where("id", $id)->get()[0];
        $childs = DB::table('pages')->where('parent', $id)->get();
        foreach($childs as $child){
            $this->dropPages($child->id);
        }
        $image = $this->imageFolder().$item->image;
        DB::table('pages')->where('id', '=', $id)->delete();
        $this->deleteFile($image);
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
            "id" => $request->input('id'),
            "title" => $request->input('title'),
            "short" => $request->input('short'),
            "content" => preg_replace("/style=\".+?\"/", "", $request->input('content')),
            "image" => $imageName,
            "created" => now(),
            "updated" => now(),
            "parent" => $request->input('parent')
        ]);
        return redirect()->route('admin', [ 'id' => $request->input('parent') ]);
    }

    public function categoryControl(Request $request) {
        $id = $request->input("id");
        $allowUpdate = $request->input("allowUpdate") == "1";
        $idCheck = DB::table('pages')->where("id", $id)->get();
        if ($allowUpdate) {
            if (sizeof($idCheck) != 0) {
                DB::table('pages')->where("id", $id)->update([
                    "title" => $request->input("title"),
                    "updated" => now(),
                    "sortOrder" => $request->input("sortOrder")
                ]);
                return response()->json(["result" => true, "msg" => "done"], 200);
            }
            return response()->json(["result" => false, "msg" => "Such an id is not exists"], 200);
        } else {
            if (sizeof($idCheck) == 0) {
                DB::table('pages')->insert([
                    "id" => $id,
                    "title" => $request->input("title"),
                    "parent" => $request->input("parent"),
                    "isContainer" => true,
                    "sortOrder" => $request->input("sortOrder")
                ]);
                return response()->json(["result" => true, "msg" => "done"], 200);
            }
            return response()->json(["result" => false, "msg" => "Such an id already exists"], 200);
        }
    }

    public function removePage($id) {
        $item = DB::table('pages')->where("id", $id)->get();
        if (sizeof($item) != 0) {
            $parent = $item[0]->parent;
            $this->dropPages($item[0]->id);
            return redirect()->route('admin', ['id' => $parent]);
        }
        return "404";
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
            "short" => $request->input('short'),
            "content" => preg_replace("/style=\".+?\"/", "", $request->input('content')),
            "updated" => now()
        ]);
        $parent = DB::table('pages')->where('id', $id)->get()[0]->parent;
        return redirect()->route('admin', [ "id" => $parent ]);
    }
}
