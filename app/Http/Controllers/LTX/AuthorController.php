<?php

namespace App\Http\Controllers\LTX;

use App\Models\LTX\Author;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index($id)
    {
        $authors = Author::where('thesis_id', $id)
            ->where('type', 'author')
            ->get();

        return response()-> json([
            'success' => true,
            'status' => 'success',
            'authors' => $authors,
        ]);  
    }

    public function update($thesis, $author_list)
    {
        $collaborators = explode('|', $author_list);

        $currentAuthors = Author::where('thesis_id', $thesis->id)->get();

        $newAuthors = [];
        foreach ($collaborators as $author) {
            list($name, $type) = explode("^", $author);
            $newAuthors[] = [
                'name' => trim($name),
                'type' => trim($type),
                'thesis_id' => $thesis->id
            ];
        }
        foreach ($newAuthors as $newAuthor) {
            $existingAuthor = Author::where('thesis_id', $thesis->id)
                ->where('name', $newAuthor['name'])
                ->where('type', $newAuthor['type'])
                ->first();

            if ($existingAuthor) {
                $existingAuthor->update($newAuthor);
            } else {
                Author::create($newAuthor);
            }
        }
        foreach ($currentAuthors as $currentAuthor) {
            $authorFound = false;
            foreach ($newAuthors as $newAuthor) {
                if ($currentAuthor->name == $newAuthor['name'] && $currentAuthor->type == $newAuthor['type']) {
                    $authorFound = true;
                    break;
                }
            }
            if (!$authorFound) {
                $currentAuthor->delete();
            }
    
        }
    }
}
