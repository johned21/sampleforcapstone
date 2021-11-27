<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormMultipleUpload;
use phpDocumentor\Reflection\Types\This;

class FormController extends Controller
{
    public function index(){
        $data = FormMultipleUpload::all();
        return view ('form_upload', compact('data'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'filename'=> 'required',
            'filename.*'=> 'image|mimes:jpeg,png,jpg,,gif,svg|max:2048'
        ]);

        if($request->hasfile('filename')){
            foreach($request->file('filename') as $image){
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/image/', $name);
                $data[] = $name;
            }
        }

        $Upload_model = new FormMultipleUpload;
        $Upload_model->filename = json_encode($data);
        $Upload_model->save();
        return back()->with('success', 'Your images has been added successfully');
    }

}
