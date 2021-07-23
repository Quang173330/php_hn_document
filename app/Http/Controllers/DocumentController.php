<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Imagick;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Auth::user()->documents;
        $favoriteDocuments = Auth::user()->favorites;

        return view('user.documents.list-document', compact('documents', 'favoriteDocuments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return redirect()->route('user.documents.index');
    }

    public function upload()
    {
        return view('user.documents.upload');
    }

    public function storeUpload(DocumentRequest $request)
    {
        $file = $request->file('file');
        $url = $file->getClientOriginalName();
        $document = new Document();
        $userId = Auth::id();
        $attributes = [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'url' => $url,
            'user_id' => $userId,
        ];
        $coverPath = 'uploads/cover/' . $url . config('cover_type');
        $document->create($attributes);
        $this->saveFile($file);
        $this->genPdfThumbnail($file, $coverPath);

        return redirect()->route('home');
    }

    public function saveFile(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $path = pathinfo($filename, PATHINFO_EXTENSION);
        $file->storeAs('uploads/' . $path . '/', $filename);
    }

    public function genPdfThumbnail($file, $target)
    {   
        $imgExt = new Imagick();
        $imgExt->readImage($file . "[0]");
        $imgExt->writeImages($target, true);
    }

    public function search(Request $request)
    {
        $documents = Document::where('name', 'LIKE', '%' . $request->name . '%')->get();

        return view('user.documents.search', compact('documents'));
    }

    public function mark($id)
    {
        $document = Document::findOrFail($id);
        $userLogin = Auth::user();
        $userLogin->favorites()->attach($document);

        return redirect()->route('user.documents.index');
    }

    public function unmark($id)
    {
        $document = Document::findOrFail($id);
        $userLogin = Auth::user();
        $userLogin->favorites()->detach($document);

        return redirect()->route('user.documents.index');
    }
}
