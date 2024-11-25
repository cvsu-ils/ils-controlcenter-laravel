<?php

namespace App\Observers\LTX;

use App\Models\LTX\Theses;
use App\Models\LTX\Subject;
use App\Models\LTX\Author;

class ThesesObserver
{
    /**
     * Handle the Theses "created" event.
     *
     * @param  \App\Models\Theses  $theses
     * @return void
     */
    public function created(Theses $thesis)
    {
        //authors
        $author_list = request()->input('collaborators');
        $subject_list = request()->input('subjects');
        $collaborators = explode('|', $author_list);
        foreach ($collaborators as $author) {
           list($name,$type) = explode("^", $author);

           $authors = new Author();
           $authors->name = trim($name);
           $authors->type = trim($type);
           $authors->thesis_id = $thesis->id; 
           $authors->save();
        }
        //Subjects
        $subject = explode('|', $subject_list);
        foreach ($subject as $each){
            $subjects = new Subject();
            $subjects->name =  $each;
            $subjects->thesis_id =  $thesis->id;
            $subjects->save();
        }
        $thesis->save(); 
    }

}
