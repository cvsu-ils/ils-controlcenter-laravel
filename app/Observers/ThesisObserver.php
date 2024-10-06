<?php

namespace App\Observers;

use App\Models\Theses;
use App\Models\ThesisAuthors;
use App\Models\Subjects;

class ThesisObserver
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

           $authors = new ThesisAuthors();
           $authors->name = trim($name);
           $authors->type = trim($type);
           $authors->thesis_id = $thesis->id; 
           $authors->save();
        }

        //Subjects
        $subject = explode('|', $subject_list);
        foreach ($subject as $each){
            $subjects = new Subjects();
            $subjects->name =  $each;
            $subjects->thesis_id =  $thesis->id;
            $subjects->save();
        }

        //accession_number
        $thesis->accession_number = $this->generateAccessionNumber();
        $thesis->save(); 
    }

    private function generateAccessionNumber(){
        $max = Theses::max('id');

        $accession_number = 'EM-' .str_pad($max, 8, '0', STR_PAD_LEFT);

        return $accession_number;

    }
    

    /**
     * Handle the Theses "updated" event.
     *
     * @param  \App\Models\Theses  $theses
     * @return void
     */
    public function updated(Theses $theses)
    {
        //
    }

    /**
     * Handle the Theses "deleted" event.
     *
     * @param  \App\Models\Theses  $theses
     * @return void
     */
    public function deleted(Theses $theses)
    {
        //
    }

    /**
     * Handle the Theses "restored" event.
     *
     * @param  \App\Models\Theses  $theses
     * @return void
     */
    public function restored(Theses $theses)
    {
        //
    }

    /**
     * Handle the Theses "force deleted" event.
     *
     * @param  \App\Models\Theses  $theses
     * @return void
     */
    public function forceDeleted(Theses $theses)
    {
        //
    }
}
