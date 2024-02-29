<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormSurveyController extends Controller
{
    public function index(Request $request){
        dd($request->getPathInfo());
        return view('pages.backend.formsurvey.index');
    }
}
