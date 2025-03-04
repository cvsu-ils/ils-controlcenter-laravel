@extends('layouts.admin')

@section('title')
    Dashboard &sdot; Ladislao Theses Xplorer
@endsection

@section('main-content-header')
    <div class="content-header" style="background-image: url('/images/landing/library.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="badge badge-primary float-sm-left mb-3" href="{{ route('admin.home') }}"><i class="fas fa-arrow-alt-circle-left"></i> Back to dashboard</a>
                    <br><br><br><br>
                    <h1 class="m-0 text-white" style="text-shadow: 4px 4px 4px #404040;"><i class="fas fa-tachometer-alt"></i> Dashboard of Ladislao Theses Xplorer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb px-3 elevation-1 bg-white float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Integrated Library System</li>
                        <li class="breadcrumb-item active">Ladislao Theses Xplorer</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection 

@section('main-content')
    <style>
        /* CSS CUSTOM LIST FOR FORMS */
        .custom-list, .custom-list-active {
            margin-top: .5rem;
        }
        .custom-list > div {
            display: block;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            margin-bottom: .5rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            background-clip: padding-box;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .custom-list > div:hover {
            opacity: 0.9;
        }
        .custom-list > div > span {
            float: right;
        }
        .custom-list > div > span:hover {
            cursor: pointer;
        }
        .custom-list-active > div {
            display: block;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            margin-bottom: .5rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            background-clip: padding-box;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        
        </style>
    <div class="content">
        <div class="container-fluid">
            <hr>
            <div class="row">
                @if(!$thesis->is_published)
                <div class="col-12">
                    @if (!$thesis->full_text_id)
                        <div class="callout callout-warning">
                            <h5>
                                <i class="fas fa-exclamation-triangle text-warning"></i> Manuscript is not publish yet
                            </h5>
                            <p>To published, you must complete all the required fields and must upload a full-text PDF file.</p>
                        </div>
                    @else
                        <div class="callout callout-success">
                            <h5>
                                <i class="fas fa-check text-success"></i> E-Manuscript can now publish!
                            </h5>
                            <p>To publish, click publish below.</p>
                            <button class="btn btn-sm btn-default" onclick="publishThesis('{{$thesis->id}}')">Publish</button>
                        </div>
                    @endif
                </div>
                @endif
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cover-tab" data-toggle="tab" data-target="#cover" type="button" role="tab" aria-controls="cover" aria-selected="true"><h3 class="card-title">Cover page</h3></button>
                                  </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="biblio-tab" data-toggle="tab" data-target="#biblio" type="button" role="tab" aria-controls="biblio" aria-selected="true"><h3 class="card-title">Bibliographic Data</h3></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="koha-tab" data-toggle="tab" data-target="#koha" type="button" role="tab" aria-controls="koha" aria-selected="false"><h3 class="card-title">KOHA Data</h3></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="full-text-tab" data-toggle="tab" data-target="#full-text" type="button" role="tab" aria-controls="full-text" aria-selected="false"><h3 class="card-title">Full-text File</h3></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="toc-tab" data-toggle="tab" data-target="#toc" type="button" role="tab" aria-controls="toc" aria-selected="false"><h3 class="card-title">Table of Contents</h3></button>
                                  </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content " id="myTabContent">
                                <div class="tab-pane fade show" id="cover" role="tabpanel" aria-labelledby="cover-tab">
                                    <div class="form-group col-md-2 text-center">
                                        @if(!empty($cover))
                                        <img class="rounded" src="{{ Storage::url('ltx/covers/' . $cover->filename )}}" style="width: 190px; height: 285px;" data-image="book-cover">
                                        @else
                                        <img class="rounded" src="http://library.cvsu.edu.ph/controlcenter/resources/images/covers/ebooks/open_access/default.jpg" style="width: 190px; height: 285px;" data-image="book-cover">
                                        @endif
                                        <br><br>
                                        <div class="dropdown">                                          
                                            <button class="btn bg-gradient-primary" type="button" data-toggle="fileImage"><i class="fas fa-images"></i> Select file...</button>
                                        </div>                                   
                                    </div>                               
                                </div>
                                <div class="tab-pane fade show active" id="biblio" role="tabpanel" aria-labelledby="biblio-tab">
                                    <form class="needs-validation" novalidate>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Item Type">Item Type</label>
                                                        <select class="form-control" name="itemType" data-validate="fileType">
                                                            <option value="" disabled selected>Choose a item type</option>
                                                            @foreach($item_types as $type)
                                                                <option value="{{$type->id}}" {{ $thesis->item_type_id == $type->id ? 'selected' : '' }}> {{$type->name}} </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback" data-valid="fileType">Item type is valid!</div>
                                                        <div class="invalid-feedback" data-invalid="fileType">Please select a item type!</div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Language">Language</label>
                                                        <select class="form-control" name="language" data-validate="fileType">
                                                            <option value="" disabled selected>Choose a language</option>
                                                            <option value="english" {{ $thesis->language == 'english' ? 'selected' : '' }}>English</option>
                                                            <option value="filipino" {{ $thesis->language == 'filipino' ? 'selected' : '' }}>Filipino</option>
                                                        </select>
                                                        <div class="valid-feedback" data-valid="fileType">Language is valid!</div>
                                                        <div class="invalid-feedback" data-invalid="fileType">Please select a language!</div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Subject Code">Subject Code</label>
                                                        <select class="form-control" name="subjectCode" data-validate="fileType">
                                                            <option value="" disabled selected>Choose a subject code</option>
                                                            @foreach($subject_codes as $code)
                                                                <option value="{{$code->id}}" {{ $thesis->subject_code_id == $code->id ? 'selected' : '' }}>{{$code->code}} - {{$code->name}} </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback" data-valid="fileType">Subject Code is valid!</div>
                                                        <div class="invalid-feedback" data-invalid="fileType">Please select a subject code!</div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Program">Program</label>
                                                        <select class="form-control" name="program" data-validate="fileType">
                                                            <option value="" disabled>Choose a program</option>
                                                            @foreach($programs as $program)
                                                                <option value="{{$program->id}}" {{ $thesis->program_id == $program->id ? 'selected' : '' }}>{{$program->name}} </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback" data-valid="fileType">Program is valid!</div>
                                                        <div class="invalid-feedback" data-invalid="fileType">Please select a program!</div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-form-label" for="Title">Title</label>
                                                        <textarea class="form-control" rows="3" name="title" placeholder="Type title..." style="margin-top: 0px; margin-bottom: 0px; min-height: 62px;" data-validate="title" value="{{ old('title', $thesis->title) }}">{{$thesis->title }}</textarea>
                                                            <div class="valid-feedback" data-valid="title">
                                                                Title is valid!
                                                            </div>
                                                            <div class="invalid-feedback" data-invalid="title"></div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Publication Place">Publication Place</label>
                                                        <input type="text" class="form-control" name="publicationPlace" placeholder="Type publisher place ..." data-autocomplete="publicationPlace" value="{{$thesis->publication_place}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Publisher">Publisher</label>
                                                        <input type="text" class="form-control" name="publisher" placeholder="Type publisher ..." data-autocomplete="publisher" value="{{$thesis->publisher}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Year">Year</label>
                                                        <input type="text" class="form-control" name="year" placeholder="Type year ..." autocomplete="off" data-validate="year" value="{{$thesis->year}}">
                                                        <div class="valid-feedback" data-valid="year">
                                                           Year is valid!
                                                        </div>
                                                        <div class="invalid-feedback" data-invalid="year"></div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="col-form-label" for="Pages">Pages</label>
                                                        <input type="text" class="form-control" name="pages" maxlength="20" placeholder="Type Pages ..." autocomplete="off" data-validate="pages" value="{{$thesis->pages}}">
                                                        <div class="valid-feedback" data-valid="pages">
                                                            Pages is valid!
                                                        </div>
                                                        <div class="invalid-feedback" data-invalid="pages"></div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-form-label" for="Author">Adviser</label>
                                                        <input type="text" class="form-control" placeholder="Type adviser ..."  data-autocomplete="relatorName" data-validate="adviser" value="{{$adviser->name}}">
                                                        <div class="valid-feedback" data-valid="adviser">
                                                            Adviser is valid!
                                                        </div>
                                                        <div class="invalid-feedback" data-invalid="adviser"></div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-8">
                                                    <label class="col-form-label" for="Author">Author</label>
                                                    <input type="text" class="form-control" placeholder="Type an entry ..." data-validate="collaborator" data-autocomplete="relatorName">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="col-form-label text-white" for="Author">Add Statement of Responsibility</label>
                                                    <button class="btn bg-gradient-primary" data-submit="addCollaborator" disabled>Add Author</button>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 custom-list" data-list="collaboratorList"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Other Physical Details</label>
                                            <textarea class="form-control" rows="3" name="physicalDescription" placeholder="Type other physical details..." style="margin-top: 0px; margin-bottom: 0px; min-height: 62px;" value="{{$thesis->physical_description}}">{{$thesis->physical_description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>General Note</label>
                                            <textarea class="form-control" rows="3" name="generalNotes" placeholder="Type general note..." style="margin-top: 0px; margin-bottom: 0px; min-height: 124px;" value="{{$thesis->general_notes}}">{{$thesis->general_notes}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Bibliography, etc. note</label>
                                            <textarea class="form-control" rows="3" name="bibliography" placeholder="Type bibliography, etc. note..." style="margin-top: 0px; margin-bottom: 0px; min-height: 124px;" value="{{$thesis->bibliography}}">{{$thesis->bibliography}}</textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label class="col-form-label" for="Subject">Subjects</label>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <input type="text" class="form-control" placeholder="Type subject ..." data-validate="subject" data-autocomplete="subject">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button class="btn bg-gradient-primary" data-submit="addSubject" disabled>Add subject</button>
                                            </div>
                                            <div class="col-md-12 custom-list" data-list="subjects"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Summary</label>
                                            <textarea class="form-control" rows="3" name="summary" placeholder="Type summary..." style="margin-top: 0px; margin-bottom: 0px; min-height: 124px;"value="{{$thesis->summary}}">{{$thesis->summary}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Table of Contents</label>
                                            <textarea class="form-control" rows="3" name="tableOfContents" placeholder="Type table of Contents..." style="margin-top: 0px; margin-bottom: 0px; min-height: 124px;"value="{{$thesis->table_of_contents}}">{{$thesis->table_of_contents}}</textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label class="col-form-label" for="Category">LC Classification</label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <select class="form-control" data-validate="class" >
                                                    <option value="" disabled>Choose a class</option>
                                                   
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->id}}" {{ $class->id == $classId ? 'selected' : '' }}> {{$class->code}}   - {{$class->description}} </option>
                                                    @endforeach
                                                </select>
                                                <div class="valid-feedback" data-valid="class">
                                                    LC Class is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="class">
                                                    Please select LC class!
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <select class="form-control" data-validate="subclass" disabled>
                                                    <option value="" disabled selected>Choose a sub class</option>
                                                </select>
                                                <div class="valid-feedback" data-valid="subclass">
                                                    LC Subclass is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="subclass">
                                                    Please select LC subclass!
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="range" data-validate="range" disabled>
                                                    <option value="" disabled selected>Choose a range</option>
                                                </select>
                                                <div class="valid-feedback" data-valid="range">
                                                    LC Range is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="range">
                                                    Please select LC range!
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" class="form-control" name="endings" placeholder="Type call number..." autocomplete="off" data-validate="endings" value="{{$thesis->cutter_ending}}">
                                                <div class="valid-feedback" data-valid="endings">
                                                    LC call number is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="endings">
                                                    LC call number is required!
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label" for="Date curated">Date curated</label>
                                                <input type="text" class="form-control" name="dateCurated" readonly data-default="dateCurated">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="col-form-label" for="Encoded by">Encoded by</label>
                                                <input type="hidden" class="form-control" name="encodedByID" value="{{ $googleUserInfo->id }}" readonly>
                                                <input type="text" class="form-control" value="{{ $googleUserInfo->givenName }}" readonly>
                                            </div>
                                        </div>
                                        <button class="btn bg-gradient-primary float-right" data-submit="ebookOpenAccess" disabled>Submit</button>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="koha" role="tabpanel" aria-labelledby="koha-tab">koha</div>
                                <div class="tab-pane fade" id="full-text" role="tabpanel" aria-labelledby="full-text-tab">
                                    
                                    @foreach ($full_texts as $full_text)
                                        <div class="container-fluid border m-2 p-3"> 
                                            <div>
                                                <i class="fas fa-file-pdf"></i> {{ $full_text->filename }}
                                                @if($full_text->id == $thesis->full_text_id)
                                                    <em>(active)</em>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                
                                    <form id="full-text" class="full-text" enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" name="thesis_id" id="thesis_id" value="{{$thesis->id}}" hidden>
                                    <div class="input-group is-invalid m-2">
                                        <div class="form-group">
                                            <label for="full_text">Full text</label>
                                            <input type="file" class="form-control-file" id="full_text" name="full_text" accept=".pdf">
                                          </div>
                                      </div>
                                      <button class="btn btn-primary" type="submit">Submit</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="toc" role="tabpanel" aria-labelledby="toc-tab">toc</div>
                            </div>
                        </div>
                    </div>
                    

                     
                </div>
            </div>
            <hr>
			<?php //$this->app->view->ForceRender('ebooks/partials/tabs');?>
            <hr>
        </div>
    </div>
@endsection

@section('script')
<script>

    toastr.options = {
        "closeButton": true, 
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true, 
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    // CREATE EBOOKS VALIDATION
    const form = document.querySelector('.needs-validation');

    const dateCurated = document.querySelector('[data-default="dateCurated"]');
    const coverImage = document.querySelector('[data-image="book-cover"]');

    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0');
    let yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    dateCurated.value = today;

    const inputTitle = document.querySelector('[data-validate="title"]');
    const validTitle = document.querySelector('[data-valid="title"]');
    const invalidTitle = document.querySelector('[data-invalid="title"]');

    const inputPage = document.querySelector('[data-validate="pages"]');
    const validPage = document.querySelector('[data-valid="pages"]');
    const invalidPage = document.querySelector('[data-invalid="pages"]');

    const inputLink = document.querySelector('[data-validate="link"]');
    const validLink = document.querySelector('[data-valid="link"]');
    const invalidLink = document.querySelector('[data-invalid="link"]');

    const inputYear = document.querySelector('[data-validate="year"]');
    const validYear = document.querySelector('[data-valid="year"]');
    const invalidYear = document.querySelector('[data-invalid="year"]');

    const selectFileType = document.querySelector('[data-validate="fileType"]');
    const validFileType = document.querySelector('[data-valid="fileType"]');
    const invalidFileType = document.querySelector('[data-invalid="fileType"]');

    const selectClass = document.querySelector('[data-validate="class"]');
    const validClass = document.querySelector('[data-valid="class"]');
    const invalidClass = document.querySelector('[data-invalid="class"]');

    const selectSubClass = document.querySelector('[data-validate="subclass"]');
    let selectSubClassSelected = "";
    const validSubClass = document.querySelector('[data-valid="subclass"]');
    const invalidSubClass = document.querySelector('[data-invalid="subclass"]');

    const selectRange = document.querySelector('[data-validate="range"]');
    const validRange = document.querySelector('[data-valid="range"]');
    const invalidRange = document.querySelector('[data-invalid="range"]');

    const inputEndings = document.querySelector('[data-validate="endings"]');
    const validEndings = document.querySelector('[data-valid="endings"]');
    const invalidEndings = document.querySelector('[data-invalid="endings"]');

    const inputSubject = document.querySelector('[data-validate="subject"]');
    const subjectList = document.querySelector('[data-list="subjects"]');
    const btnAddSubject = document.querySelector('[data-submit="addSubject"]');

    const inputAdviser = document.querySelector('[data-validate="adviser"]');
    const validAdviser = document.querySelector('[data-valid="adviser"]');
    const invalidAdviser = document.querySelector('[data-invalid="adviser"]');

    const inputCollaborator = document.querySelector('[data-validate="collaborator"]');
    const collaboratorList = document.querySelector('[data-list="collaboratorList"]');
    const btnAddCollaborator = document.querySelector('[data-submit="addCollaborator"]');

    const inputDateOfPublication = document.querySelector('[data-validate="dateOfPublication"]');

    const defaultCoverBtn = document.querySelector('[data-toggle="defaultImage"]');
    const isbnDefaultBtn = document.querySelector('[data-toggle="isbnImage"]');
    const imageLinkBtn = document.querySelector('[data-toggle="imageLink"]');
    const fileImageBtn = document.querySelector('[data-toggle="fileImage"]');

    const btnSubmit = document.querySelector('[data-submit="ebookOpenAccess"]');

    const fullTextForm = document.querySelector('.full-text');


    let isTitleReady = false;
    let isCopyrightYearReady = false;
    let isPageReady = false;
    let isFileTypeReady = false;
    let isCategoryReady = false;
    let isClassReady = false;
    let isSubClassReady = false;
    let isRangeReady = false;
    let isAdviserReady = false;
    let isCutterEndingReady = false;

    let isDateOfPublication = true;

    let collaborators = [];
    let relatorsTermsId = [];
    let relatorsTerms = [];
    let maxCollaborators = 5;
    let subjects = [];
    let maxSubjects = 5;

    let isbnSrc = null;
    let imageURLSrc = null;
    let fileImageSrc = null;

    let coverType = null;
    let isGoogleBookAPI = true;

    let thesisId ="{{$thesis->id}}";
    let rangeId = "{{$thesis->range}}";

    console.log(rangeId)

    
    checkClass();

    form.addEventListener("keyup", function(e) {
        checkForm();
    });
    form.addEventListener("change", function(e) {
        checkForm();
    });
    // PREVENT `ENTER` KEY FROM SUBMITTING THE FORM
    form.addEventListener("keydown", function(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
    console.log(selectClass.value);
    
    function checkForm() {
        //region Validate year
        if(inputYear.value === "" || isNaN(inputYear.value)) {
            isCopyrightYearReady = false;
            ShowValidation(inputYear, "is-invalid");
        } else {
            isCopyrightYearReady = true;
            ShowValidation(inputYear, "is-valid");
        }
        //endregion
        //region # Validate title
        if(inputTitle.value === "") {
            isTitleReady = false;
            ShowValidation(inputTitle, "is-invalid");
            invalidTitle.innerHTML = "Title field cannot be empty!";
        } else {
            isTitleReady = true;
            ShowValidation(inputTitle, "is-valid");
        }
        //endregion
        //region Validate page
        if(inputPage.value === "" || isNaN(inputPage.value)) {
            isPageReady = false;
            ShowValidation(inputPage, "is-invalid");
        } else {
            isCopyrightYearReady = true;
            ShowValidation(inputPage, "is-valid");
        }

        //region Validate fileType
        if(selectFileType.value === "") {
            isFileTypeReady = false;
            ShowValidation(selectFileType, "is-invalid");
        } else {
            isFileTypeReady = true;
            ShowValidation(selectFileType, "is-valid");
        }
        //endregion

        if(selectClass.value === "") {
            isClassReady = false;
            ShowValidation(selectClass, "is-invalid");
            if(!selectSubClass.hasAttribute("disabled")) {
                selectSubClass.setAttribute("disabled", "");
            }
        } else {
            if(selectClass === document.activeElement) {
                isClassReady = true;
                isSubClassReady = false;
                isRangeReady = false;
                ShowValidation(selectClass, "is-valid");
                selectSubClass.removeAttribute("disabled");
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.ltx.subclasses') }}",
                    data: "classid=" + selectClass.value,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                    },
                    success: function(response) {
                        if(response.status === "success") {
                            ShowValidation(selectSubClass, "is-invalid");
                            ShowValidation(selectRange, "is-invalid");
                            if(!selectRange.hasAttribute("disabled")) {
                                selectRange.setAttribute("disabled", "");
                            }                          
                                selectSubClass.innerHTML = '<option value="" disabled selected>Choose a sub class</option>';
                            
                                selectRange.innerHTML = '<option value="" disabled selected>Choose a range</option>';

                            const sub_classes = response.data;
                            sub_classes.forEach(function(sub_class){
                                var subclass_option = document.createElement("option");
                                subclass_option.value = sub_class.id;
                                subclass_option.textContent = sub_class.code + ' - ' + sub_class.description;
                                selectSubClass.appendChild(subclass_option);
                               
                            });
                        }
                    }
                });
            }
        }
        //endregion
        //region Validate subclass
        if(selectSubClass.value === "") {       
            isSubClassReady = false; 
            ShowValidation(selectSubClass, "is-invalid");
            if(!selectRange.hasAttribute("disabled")) {
                selectRange.setAttribute("disabled", "");
            }
        } else {
            if(selectSubClass === document.activeElement) {
                isSubClassReady = true;
                isRangeReady = false;
                ShowValidation(selectSubClass, "is-valid");
                selectRange.removeAttribute("disabled");
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.ltx.ranges') }}",
                    data: "subclassid=" + selectSubClass.value,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                    },
                    success: function(response) {
                        if(response.status === "success") {
                            ShowValidation(selectRange, "is-invalid");
                            selectRange.innerHTML = '<option value="" disabled selected>Choose a range</option>';
                            const ranges = response.data;
                            ranges.forEach(function(range){
                                var range_option = document.createElement("option");
                                range_option.value = range.id;
                                range_option.textContent = range.range + ' - ' + range.description;
                                selectRange.appendChild(range_option);
                               
                            });
                        }
                    }
                });
            }
        }
        //endregion
        //region Validate range
        if(selectRange.value === "") {
            isRangeReady = false;
            ShowValidation(selectRange, "is-invalid");
        } else {
           
                isRangeReady = true;
                ShowValidation(selectRange, "is-valid");
            
        }
        //region Validate cutter endings
        if(inputEndings.value === "") {
            isCutterEndingReady = false;
            ShowValidation(inputEndings, "is-invalid");
        } else {
           
                isCutterEndingReady = true;
                ShowValidation(inputEndings, "is-valid");
            
        }
        //endregion
           
        if(inputCollaborator.value != "") {
            btnAddCollaborator.removeAttribute("disabled");
        } else {
            if(!btnAddCollaborator.hasAttribute("disabled")) {
                btnAddCollaborator.setAttribute("disabled", "");
            }
        }

        if(inputSubject.value != "") {
            btnAddSubject.removeAttribute("disabled");
        } else {
            if(!btnAddSubject.hasAttribute("disabled")) {
                btnAddSubject.setAttribute("disabled", "");
            }
        }
        //region # Validate Adviser
        if(inputAdviser.value === "") {
            isAdviserReady = false;
            ShowValidation(inputAdviser, "is-invalid");
            invalidAdviser.innerHTML = "Adviser field cannot be empty!";
        } else {
            isAdviserReady = true;
            ShowValidation(inputAdviser, "is-valid");
        }
        //endregion

        CheckSubmitBtn();
    }


    function checkClass() {

        //region Validate year
        if(inputYear.value === "" || isNaN(inputYear.value)) {
                isCopyrightYearReady = false;
                ShowValidation(inputYear, "is-invalid");
            } else {
                isCopyrightYearReady = true;
                ShowValidation(inputYear, "is-valid");
            }
            //endregion
            //region # Validate title
            if(inputTitle.value === "") {
                isTitleReady = false;
                ShowValidation(inputTitle, "is-invalid");
                invalidTitle.innerHTML = "Title field cannot be empty!";
            } else {
                isTitleReady = true;
                ShowValidation(inputTitle, "is-valid");
            }
            //endregion
            //region Validate page
            if(inputPage.value === "" || isNaN(inputPage.value)) {
                isPageReady = false;
                ShowValidation(inputPage, "is-invalid");
            } else {
                isCopyrightYearReady = true;
                ShowValidation(inputPage, "is-valid");
            }

            //region Validate fileType
            if(selectFileType.value === "") {
                isFileTypeReady = false;
                ShowValidation(selectFileType, "is-invalid");
            } else {
                isFileTypeReady = true;
                ShowValidation(selectFileType, "is-valid");
            }
            //endregion

            //region # Validate Adviser
            if(inputAdviser.value === "") {
                isAdviserReady = false;
                ShowValidation(inputAdviser, "is-invalid");
                invalidAdviser.innerHTML = "Adviser field cannot be empty!";
            } else {
                isAdviserReady = true;
                ShowValidation(inputAdviser, "is-valid");
            }
            //endregion
            if(inputEndings.value === "") {
                isCutterEndingReady = false;
                ShowValidation(inputEndings, "is-invalid");
            } else {
            
                    isCutterEndingReady = true;
                    ShowValidation(inputEndings, "is-valid");
                
            }
        let subClassId = parseInt("{{$subclass}}");
        console.log("SubClass ID from backend:", subClassId);

        isClassReady = true;
        isSubClassReady = true;
        isRangeReady = true;

        ShowValidation(selectClass, "is-valid");
        selectSubClass.removeAttribute("disabled");

        $.ajax({
            type: "POST",
            url: "{{ route('admin.ltx.subclasses') }}",
            data: "classid=" + selectClass.value,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === "success") {
                    ShowValidation(selectSubClass, "is-valid");
                    
                    selectSubClass.innerHTML = '<option value="" disabled>Choose a sub class</option>';     

                    const sub_classes = response.data;
                    sub_classes.forEach(function(sub_class) {
                        var subclass_option = document.createElement("option");
                        subclass_option.value = sub_class.id;
                        subclass_option.textContent = sub_class.code + ' - ' + sub_class.description;

                        if (sub_class.id === subClassId) {
                            subclass_option.setAttribute("selected", "");
                        }
                        selectSubClass.appendChild(subclass_option);
                    });

                    // Log value after population
                    selectSubClassSelected = selectSubClass.value;
                    console.log("Selected SubClass ID after population:", selectSubClassSelected)
                    populateRange(selectSubClassSelected);
                }
            }
        });

        CheckSubmitBtn()
    }
    console.log("Selected SubClass value before AJAX response:", selectSubClassSelected);

    function populateRange(SubClassId) {
        ShowValidation(selectRange, "is-valid");                     
        selectRange.innerHTML = '<option value="" disabled selected>Choose a range</option>';

        isSubClassReady = true;
        isRangeReady = true;
        ShowValidation(selectSubClass, "is-valid");
        selectRange.removeAttribute("disabled");
        $.ajax({
            type: "POST",
            url: "{{ route('admin.ltx.ranges') }}",
            data: "subclassid=" + SubClassId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
            },
            success: function(response) {
                if(response.status === "success") {
                    ShowValidation(selectRange, "is-valid");
                    selectRange.innerHTML = '<option value="" disabled>Choose a range</option>';
                    const ranges = response.data;
                    ranges.forEach(function(range){
                        var range_option = document.createElement("option");
                        range_option.value = range.id;
                        range_option.textContent = range.range + ' - ' + range.description + range.id;

                        if (range.id === rangeId) {
                            range_option.setAttribute("selected", "");
                        }
                        selectRange.appendChild(range_option);
                    
                    });
                }
            }
        });
    }

    function CheckSubmitBtn() {
         console.log("isTitleReady: " + isTitleReady + "; isCopyrightYearReady: " + isCopyrightYearReady + "; isFileTypeReady: " + isFileTypeReady + "; isCategoryReady: " + isCategoryReady + "; isClassReady: " + isClassReady + "; isSubClassReady: " + isSubClassReady + "; isRangeReady: " + isRangeReady + "; isCutterEndingReady: " + isCutterEndingReady + ";");
        if(isTitleReady && isCopyrightYearReady && isClassReady && isSubClassReady && isRangeReady && isCutterEndingReady && isDateOfPublication) {
            btnSubmit.removeAttribute("disabled");
        } else {
            if(!btnSubmit.hasAttribute("disabled")) {
                btnSubmit.setAttribute("disabled", "");
            }
        }
    }

    fileImageBtn.addEventListener("click", (e) => {
        (async () => {
            const { value: file } = await Swal.fire({
                title: '<i class="fas fa-images"></i> Select file image',
                input: 'file',
                inputAttributes: {
                    'accept': 'image/*',
                    'aria-label': 'Upload your profile picture'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit'
            })
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    Swal.fire({
                        text: 'Are you sure you want to use this image?',
                        imageUrl: e.target.result,
                        imageWidth: 200,
                        imageHeight: 285,
                        imageAlt: 'The uploaded picture',
                        showCancelButton: true,
                        confirmButtonText: 'Use image'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const imgFormData = new FormData();
                            imgFormData.append('file', file);
                            imgFormData.append('thesis_id', thesisId);
                            imgFormData.append('updated_by', "{{ $googleUserInfo->id }}");

                            console.log(imgFormData);


                            // AJAX request
                            $.ajax({
                                type: "POST",
                                url: "{{ route('admin.ltx.cover.store') }}",
                                data: imgFormData,
                                headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                                },
                                processData: false, 
                                contentType: false,
                                success: function (response) {
                                    if (response.success) {
                                        const fileImageSrc = e.target.result;
                                        coverImage.src = fileImageSrc;
                                        imageURLSrc = null;
                                        coverType = 'FILE';
                                        toastr.success(response.message, 'Success');
                                    
                                    } else {
                                        toastr.error(response.message, 'Error');
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error(xhr.responseText); // Log the error message
                                    alert('An error occurred: ' + xhr.responseJSON.message); // Show error message
                                }
                            });
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        })();
    });

    //COVER 
    function setDefaultCover() {
        imageURLSrc = null;
        isbnSrc = null;
        fileImageSrc = null;
        coverImage.src = "resources/images/covers/ebooks/open_access/default.jpg";
        coverType = 'DEFAULT';
    }
    thesisAuthors();
    thesisSubjects();

    function thesisAuthors(){
        fetch(`authors`)
        .then(response => response.json())
        .then(data => { 
            const authors = data.authors;
            
            authors.forEach(function(author){    
                if(collaborators.length < maxCollaborators) {   
                    collaborators.push(author.name);
                    const div = document.createElement('div');
                    div.className = 'bg-primary';
                    div.id = "collaborator-" + collaborators.length;
                    div.innerHTML = collaborators.length + ". " + author.name + ' [ author ] <span onclick="removeCollaborator(' + collaborators.length + ')"><i class="fas fa-times"></i></span>';
                    collaboratorList.appendChild(div);
                }
            });
        });
    }

    btnAddCollaborator.addEventListener("click", function(e) {
        e.preventDefault();   
        if(inputCollaborator.value != "") {
            if(collaborators.length < maxCollaborators) {
                collaborators.push(inputCollaborator.value);
                console.log(collaborators)

                const div = document.createElement('div');
                div.className = 'bg-primary';
                div.id = "collaborator-" + collaborators.length;
                div.innerHTML = collaborators.length + ". " + inputCollaborator.value + ' [ author ] <span onclick="removeCollaborator(' + collaborators.length + ')"><i class="fas fa-times"></i></span>';
                collaboratorList.appendChild(div);

                inputCollaborator.value = "";

                if(collaborators.length < maxCollaborators) {
                    if(!btnAddCollaborator.hasAttribute("disabled")) {
                        btnAddCollaborator.setAttribute("disabled", "");
                    } else {
                        btnAddCollaborator.removeAttribute("disabled");
                    }
                }
                if(collaborators.length === maxCollaborators) {
                    if(!inputCollaborator.hasAttribute("disabled")) {
                        inputCollaborator.setAttribute("disabled", "");
                    } else {
                        inputCollaborator.removeAttribute("disabled");
                    }
                }
            }
        }
    });

    function thesisSubjects(){
        fetch(`subjects`)
        .then(response => response.json())
        .then(data => { 
            const thesis_subjects = data.subjects;

            thesis_subjects.forEach(function(subject){ 
                if(subjects.length < maxSubjects) {
                    subjects.push(subject.name);                  
                    const div = document.createElement('div');
                    div.className = 'bg-primary';
                    div.id = "subject-" + subjects.length;
                    div.innerHTML = subjects.length + ". " + subject.name + ' <span onclick="removeSubject(' + subjects.length + ')"><i class="fas fa-times"></i></span>';
                    subjectList.appendChild(div);

                }
            });
        });
    }
        
    btnAddSubject.addEventListener("click", function(e) {
        e.preventDefault();
        if(inputSubject.value != "") {
            if(subjects.length < maxSubjects) {
                subjects.push(inputSubject.value);

                const div = document.createElement('div');
                div.className = 'bg-primary';
                div.id = "subject-" + subjects.length;
                div.innerHTML = subjects.length + ". " + inputSubject.value + ' <span onclick="removeSubject(' + subjects.length + ')"><i class="fas fa-times"></i></span>';
                subjectList.appendChild(div);

                inputSubject.value = "";
                if(subjects.length < maxSubjects) {
                    if(!btnAddSubject.hasAttribute("disabled")) {
                        btnAddSubject.setAttribute("disabled", "");
                    } else {
                        btnAddSubject.removeAttribute("disabled");
                    }
                }
                if(subjects.length === maxSubjects) {
                    if(!inputSubject.hasAttribute("disabled")) {
                        inputSubject.setAttribute("disabled", "");
                    } else {
                        inputSubject.removeAttribute("disabled");
                    }
                }
            }
        }
    });

    function removeCollaborator(id) {
        const index = id - 1;
        if (index > -1) {
            collaborators.splice(index, 1);
            relatorsTermsId.splice(index, 1);
            relatorsTerms.splice(index, 1);
        }
        collaboratorList.innerHTML = '';

        let i = 1;
        collaborators.forEach((collaborator) => {
            const div = document.createElement('div');
            div.className = 'bg-primary';
            div.id = "collaborator-" + i;
            div.innerHTML = i + ". " + collaborator + ' [author] <span onclick="removeCollaborator(' + i + ')"><i class="fas fa-times"></i></span>';
            collaboratorList.appendChild(div);
            i++;
        });
        if(collaborators.length < maxCollaborators) {
            inputCollaborator.removeAttribute("disabled");
        }
    }

    function removeSubject(id) {
        const index = id - 1;
        if (index > -1) {
            subjects.splice(index, 1);
        }
        subjectList.innerHTML = '';

        let i = 1;
        subjects.forEach((subject) => {
            const div = document.createElement('div');
            div.className = 'bg-primary';
            div.id = "subject-" + i;
            div.innerHTML = i + ". " + subject + ' <span onclick="removeSubject(' + i + ')"><i class="fas fa-times"></i></span>';
            subjectList.appendChild(div);
            i++;
        });
        if(subjects.length < maxSubjects) {
            inputSubject.removeAttribute("disabled");
        }
    }

    console.log(isTitleReady,isCopyrightYearReady, isCategoryReady,isClassReady, isPageReady, isSubClassReady, isRangeReady, isCutterEndingReady, isDateOfPublication)
    form.addEventListener("submit", function(e) {
        e.preventDefault(); 
        if(!isTitleReady && !isCopyrightYearReady && !isFileTypeReady && !isCategoryReady && !isClassReady && !isPageReady && !isSubClassReady && !isRangeReady && !isCutterEndingReady && !isDateOfPublication) {
            return false;
        }
        btnSubmit.setAttribute("disabled", "");
        let collaboratorsWithRelatorTerms = [];
        let i = 0;
        collaborators.forEach((collaborator) => {
            collaboratorsWithRelatorTerms.push(collaborator + "^author");
            i++;
        });
        let bookCover = document.querySelector('[data-image="book-cover"]').src;
        let module = "EBookOpenAccessCreate";
        let dataQuery = $(this).serialize();
        let adviserName = inputAdviser.value + '^adviser';

        collaboratorsWithRelatorTerms.push(adviserName);
        console.log("module=" + module + "&" + dataQuery + "&subjects=" + subjects.join("|") + "&collaborators=" + collaboratorsWithRelatorTerms.join("|"));
        $.ajax({
            type: "PUT",
            url: "{{ route('admin.ltx.update', ':id') }}".replace(':id', thesisId),
            data: "module=" + module + "&" + dataQuery + "&subjects=" + subjects.join("|") + "&collaborators=" + collaboratorsWithRelatorTerms.join("|"),
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            success: function(response) {
                console.log(response);
               
                if(response.status === "success") {
                    Swal.fire({
                    title: response.message,
                    icon: response.status,
                });
                    resetForm();
                } else {
                    btnSubmit.removeAttribute("disabled", "");
                }
             }
        });
     });

    function resetForm() {
        form.reset();
        ShowValidation(inputYear, "REMOVEALL");
        ShowValidation(inputTitle, "REMOVEALL");
        ShowValidation(inputPage, "REMOVEALL");
        ShowValidation(inputAdviser, "REMOVEALL");
        ShowValidation(inputLink, "REMOVEALL");
        ShowValidation(selectFileType, "REMOVEALL");
        ShowValidation(selectClass, "REMOVEALL");
        ShowValidation(selectSubClass, "REMOVEALL");
        ShowValidation(selectRange, "REMOVEALL");
        ShowValidation(inputEndings, "REMOVEALL");
        subjects = [];
        collaborators = [];
        relatorsTerms = [];
        subjectList.innerHTML = '';
        collaboratorList.innerHTML = '';
        setDefaultCover();
    }

    function ShowValidation(tag, value) {
        if(value === "REMOVEALL") {
            if(tag.classList.contains("is-invalid")) {
                tag.classList.remove("is-invalid");
            }
            if(tag.classList.contains("is-valid")) {
                tag.classList.remove("is-valid");
            }
        } else {
            if(value === "is-valid") {
                if(!tag.classList.contains(value)) {
                    tag.classList.add(value);
                }
                if(tag.classList.contains("is-invalid")) {
                    tag.classList.remove("is-invalid");
                }
            } else {
                if(!tag.classList.contains(value)) {
                    tag.classList.add(value);
                }
                if(tag.classList.contains("is-valid")) {
                    tag.classList.remove("is-valid");
                }
            }
        }
    }

    //FULL TEXT UPLOAD
    fullTextForm.addEventListener("submit", function(e) {
        e.preventDefault();


        let fullTextData = new FormData(this);
         $.ajax({
            url: '{{ route("admin.ltx.fulltext.store") }}',
            type: 'POST',
            data: fullTextData,
            headers:  {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    const inputFullText = document.getElementById('full_text');
                    inputFullText.value = '';
                } else {
                    toastr.error(response.message); 
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        toastr.error(errors[field][0]);
                    }
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            }
        });

    });

    //PUBLISH THESIS region
    function publishThesis (thesisId){
        let publishRouteUrl = "{{ route('admin.ltx.publish', ['id' => '__ID__']) }}";
        $.ajax({
            method: "PATCH",
            url: publishRouteUrl.replace('__ID__', thesisId),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                if(response.status == "success"){
                    Swal.fire({
                        title: response.message,
                        icon: response.status,
                }).then(function(){
                    window.location = "{{ route('admin.ltx.catalog') }}"
                });
                }else{
                    Swal.fire({
                        title: response.message,
                        icon: response.status,
                });
                }
                
            }
        })
    }
</script>

@endsection