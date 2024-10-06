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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit record</h3>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
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
                                                <input type="text" class="form-control" name="year" placeholder="Type year ..." autocomplete="off" data-validate="year">
                                                <div class="valid-feedback" data-valid="year">
                                                   Year is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="year"></div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="col-form-label" for="Pages">Pages</label>
                                                <input type="text" class="form-control" name="pages" maxlength="20" placeholder="Type Pages ..." autocomplete="off" data-validate="pages">
                                                <div class="valid-feedback" data-valid="pages">
                                                    Pages is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="pages"></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-form-label" for="Author">Adviser</label>
                                                <input type="text" class="form-control" placeholder="Type adviser ..."  data-autocomplete="relatorName" data-validate="adviser">
                                                <div class="valid-feedback" data-valid="adviser">
                                                    Adviser is valid!
                                                </div>
                                                <div class="invalid-feedback" data-invalid="adviser"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 text-center">
                                        <img class="rounded" src="http://library.cvsu.edu.ph/controlcenter/resources/images/covers/ebooks/open_access/default.jpg" style="width: 190px; height: 285px;" data-image="book-cover">
                                        <br><br>
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Upload cover
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <button class="dropdown-item" type="button" data-toggle="defaultImage">Default</button>
                                                <button class="dropdown-item" type="button" data-toggle="isbnImage"><i class="fas fa-book"></i> ISBN...</button>
                                                <button class="dropdown-item" type="button" data-toggle="imageLink"><i class="fas fa-link"></i> Image URL...</button>
                                                <button class="dropdown-item" type="button" data-toggle="fileImage"><i class="fas fa-images"></i> Select file...</button>
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
                                <div class="form-group">
                                    <label class="col-form-label" for="Link">Link</label>
                                    <input type="text" class="form-control" name="link" placeholder="Type link ..." autocomplete="off" data-validate="link"  value="{{$thesis->opac_link}}">
                                    <div class="valid-feedback" data-valid="link">URL is valid!</div>
                                    <div class="invalid-feedback" data-invalid="link">URL is invalid! Ex. <i class="text-info">https://cvsu.edu.ph/</i></div>
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
    let isLinkReady = false;
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

    
    checkForm();
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
        //endregion
        //region # Validate isbn
        // if(inputIsbn.value === "") {
        //     ShowValidation(inputIsbn, "REMOVEALL");
        // } else {
        //     if (inputIsbn === document.activeElement) {
        //         //getISBNImage();
        //     }
        // }
        //endregion

        //region Validate fileType
        if(selectFileType.value === "") {
            isFileTypeReady = false;
            ShowValidation(selectFileType, "is-invalid");
        } else {
            isFileTypeReady = true;
            ShowValidation(selectFileType, "is-valid");
        }
        //endregion
        //region Validate class
        if(selectClass.value === "") {
            isClassReady = false;
            ShowValidation(selectClass, "is-invalid");
            if(!selectSubClass.hasAttribute("disabled")) {
                selectSubClass.setAttribute("disabled", "");
            }
        } else {
            let subClassId = parseInt("{{$subclass}}", 10);
            console.log(subClassId);
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

                                if (sub_class.id === subClassId) {
                                    subclass_option.selected = true; // Check if this logic is correct
                                    console.log("Option Selected:", subclass_option);
                                }
                                selectSubClass.appendChild(subclass_option);
                               
                            });
                            console.log("Selected SubClass ID after population:", selectSubClass.value);
                       
                        }
                    }
                });
            
        }
        //region Validate subclass
        if(selectSubClass.value === "") {
            isSubClassReady = false;
            ShowValidation(selectSubClass, "is-invalid");
            if(!selectRange.hasAttribute("disabled")) {
                selectRange.setAttribute("disabled", "");
            }
        } else {
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
        //endregion
        //region Validate range
        if(selectRange.value === "") {
            isRangeReady = false;
            ShowValidation(selectRange, "is-invalid");
        } else {
            if(selectRange === document.activeElement) {
                isRangeReady = true;
                ShowValidation(selectRange, "is-valid");
            }
        }
        //region Validate cutter endings
        if(inputEndings.value === "") {
            isCutterEndingReady = false;
            ShowValidation(inputEndings, "is-invalid");
        } else {
            if(inputEndings === document.activeElement) {
                isCutterEndingReady = true;
                ShowValidation(inputEndings, "is-valid");
            }
        }
        //endregion
        //region Validate link
        if(inputLink.value === "") {
            isLinkReady = false;
            ShowValidation(inputLink, "is-invalid");
            invalidLink.innerHTML = "Link field cannot be empty!";
        } else {
            if(inputLink === document.activeElement) {
                isLinkReady = true;
                ShowValidation(inputLink, "is-valid");
                validLink.innerHTML = 'Validating URL <i class="fas fa-spinner fa-pulse"></i>';
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.ltx.linkChecker') }}",
                    data: "url=" + inputLink.value,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status === "success") {
                            validLink.innerHTML = "URL is valid!";
                        } else {
                            ShowValidation(inputLink, "is-invalid");
                            console.log("error");
                        }
                    }
                });
            }
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
            console.log(inputAdviser.value)
        }
        //endregion

        CheckSubmitBtn();
    }

    function CheckSubmitBtn() {
         console.log("isTitleReady: " + isTitleReady + "; isCopyrightYearReady: " + isCopyrightYearReady + "; isFileTypeReady: " + isFileTypeReady + "; isCategoryReady: " + isCategoryReady + "; isClassReady: " + isClassReady + "; isSubClassReady: " + isSubClassReady + "; isRangeReady: " + isRangeReady + "; isCutterEndingReady: " + isCutterEndingReady + "; isLinkReady: " + isLinkReady);
        if(isTitleReady && isCopyrightYearReady && isFileTypeReady && isClassReady && isSubClassReady && isRangeReady && isCutterEndingReady && isDateOfPublication && isLinkReady) {
            btnSubmit.removeAttribute("disabled");
        } else {
            if(!btnSubmit.hasAttribute("disabled")) {
                btnSubmit.setAttribute("disabled", "");
            }
        }
    }

    defaultCoverBtn.addEventListener("click", (e) => {
        setDefaultCover();
        coverType = 'DEFAULT';
    });

    isbnDefaultBtn.addEventListener("click", (e) => {
        getISBNImage("btn");
    });

    imageLinkBtn.addEventListener("click", (e) => {
        (async () => {
            const { value: url } = await Swal.fire({
                title: '<i class="fas fa-images"></i> Paste image URL below',
                input: 'url',
                //inputLabel: 'URL address',
                inputPlaceholder: 'Paste the image URL...',
                showCancelButton: true,
                confirmButtonText: 'Submit'
            });
            if (url) {
                Swal.fire({
                    text: 'Are you sure you want to use this image?',
                    imageUrl: url,
                    imageWidth: 200,
                    imageHeight: 285,
                    imageAlt: 'The uploaded picture',
                    showCancelButton: true,
                    confirmButtonText: 'Use image'
                }).then((result) => {
                    if(result.isConfirmed) {
                        imageURLSrc = url;
                        coverImage.src = imageURLSrc;
                        fileImageSrc = null;
                        coverType = 'URL';
                    };
                });
            }
        })();
    });

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
                        if(result.isConfirmed) {
                            fileImageSrc = e.target.result;
                            coverImage.src = fileImageSrc;
                            imageURLSrc = null;
                            coverType = 'FILE';
                        };
                    });
                }
                reader.readAsDataURL(file);
            }
        })();
    });

    function setDefaultCover() {
        imageURLSrc = null;
        isbnSrc = null;
        fileImageSrc = null;
        coverImage.src = "resources/images/covers/ebooks/open_access/default.jpg";
        coverType = 'DEFAULT';
    }
    // function getISBNImage(type = 'api') {
    //     $.ajax({
    //         type: "POST",
    //         url: "app/Helpers/request/ebooks/getBookWithISBN.php",
    //         data: "isbn=" + inputIsbn.value,
    //         success: function(response) {
    //             console.log(response);
    //             if(JSON.parse(response).status === "success") {
    //                 ShowValidation(inputIsbn, "is-valid");
    //                 if (JSON.parse(response).data) {
    //                     Swal.fire({
    //                         text: 'Do you want to use image from google books?',
    //                         imageUrl: JSON.parse(response).data,
    //                         imageWidth: 200,
    //                         imageHeight: 285,
    //                         imageAlt: 'The uploaded picture',
    //                         showCancelButton: true,
    //                         confirmButtonText: 'Use image'
    //                     }).then((result) => {
    //                         if(result.isConfirmed) {
    //                             isbnSrc = JSON.parse(response).data;
    //                             coverImage.src = isbnSrc;
    //                             imageURLSrc = null;
    //                             fileImageSrc = null;
    //                             coverType = 'ISBN';
    //                         };
    //                     });
    //                 }
    //             } else {
    //                 if(type != "btn") {
    //                     ShowValidation(inputIsbn, "is-invalid");
    //                     invalidIsbn.innerHTML = JSON.parse(response).message;
    //                 }
    //             }
    //         }
    //     });
    // }
       

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

    form.addEventListener("submit", function(e) {
        e.preventDefault(); 
        if(!isTitleReady && !isCopyrightYearReady && !isFileTypeReady && !isCategoryReady && !isClassReady && !isPageReady && !isSubClassReady && !isRangeReady && !isCutterEndingReady && !isDateOfPublication && !isLinkReady) {
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
        console.log("module=" + module + "&" + dataQuery + "&subjects=" + subjects.join("|") + "&collaborators=" + collaboratorsWithRelatorTerms.join("|") + "&bookCover=" + bookCover + "&coverType=" + coverType);
        $.ajax({
            type: "POST",
            url: "{{ route('admin.ltx.store') }}",
            data: "module=" + module + "&" + dataQuery + "&subjects=" + subjects.join("|") + "&collaborators=" + collaboratorsWithRelatorTerms.join("|") + "&bookCover=" + bookCover + "&coverType=" + coverType,
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
        // ShowValidation(inputCallNumber, "REMOVEALL");
        ShowValidation(inputYear, "REMOVEALL");
        ShowValidation(inputTitle, "REMOVEALL");
        ShowValidation(inputPage, "REMOVEALL");
        ShowValidation(inputAdviser, "REMOVEALL");
        ShowValidation(inputLink, "REMOVEALL");
        //ShowValidation(selectCategory, "REMOVEALL");
        //ShowValidation(selectCategory2, "REMOVEALL");
        //ShowValidation(selectCategory3, "REMOVEALL");
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

    // $(function() {
    //     $('[data-autocomplete="publicationPlace"]').autocomplete({
    //         source: 'app/Helpers/Handler.php?module=AutocompleteEbookOpenAccess&source=PublicationPlace',
    //     });
    // });

    // $(function() {
    //     $('[data-autocomplete="publisher"]').autocomplete({
    //         source: 'app/Helpers/Handler.php?module=AutocompleteEbookOpenAccess&source=Publisher',
    //     });
    // });

    // $(function() {
    //     $('[data-autocomplete="relatorName"]').autocomplete({
    //         source: 'app/Helpers/Handler.php?module=AutocompleteEbookOpenAccess&source=Relator',
    //     });
    // });

    // $(function() {
    //     $('[data-autocomplete="subject"]').autocomplete({
    //         source: 'app/Helpers/Handler.php?module=AutocompleteEbookOpenAccess&source=Subject',
    //     });
    // });
</script>

@endsection