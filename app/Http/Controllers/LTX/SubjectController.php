<?php

namespace App\Http\Controllers\LTX;

use App\Models\LTX\Subject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{

    public function index($id){
        $subjects = Subject::where('thesis_id', $id)->get();

        return response()-> json([
            'success' => true,
            'status' => 'success',
            'subjects' => $subjects,
        ]);
    }
    
    public function update($thesis, $subjects){
        $subject_list = explode('|', $subjects);

        $currentSubjects = Subject::where('thesis_id', $thesis->id)->get();

        $newSubjects = [];
        foreach ($subject_list as $subject) {
            $newSubjects[] = [
                'name' => $subject,
                'thesis_id' => $thesis->id
            ];
        }

        foreach ($newSubjects as $newSubject) {
            $existingSubject = Subject::where('thesis_id', $thesis->id)
                ->where('name', $newSubject['name'])
                ->first();
    
            if ($existingSubject) {
                $existingSubject->update($newSubject);
            } else {
                Subject::create($newSubject);
            }
        }

        foreach ($currentSubjects as $currentSubject) {
            $subjectFound = false;
            foreach ($newSubjects as $newSubject) {
                if ($currentSubject->name == $newSubject['name']) {
                    $subjectFound = true;
                    break;
                }
            }
    
            if (!$subjectFound) {
                $currentSubject->delete();
            }
        }
        


    }
}