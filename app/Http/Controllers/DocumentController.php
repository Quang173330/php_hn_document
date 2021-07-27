<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Category;
use App\Http\Requests\CommentRequest;
use App\Models\Document;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::with('categories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Auth::user()->documents;
        $favoriteDocuments = Auth::user()->favorites;
        $categories = $this->categories;

        return view('user.documents.list-document', compact('documents', 'favoriteDocuments', 'categories'));
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
        $document = Document::findOrFail($id);
        $author = $document->uploadBy;
        $comments = $document->comments()->orderBy('comments.created_at', 'desc')->get();
        $categories = $this->categories;

        return view('user.documents.show', compact('document', 'author', 'comments', 'categories'));
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
        if ($this->authorize('delete', $document)) {
            $document->delete();

            return redirect()->route('user.documents.index');
        }
    }

    public function upload()
    {
        $categories = Category::with('childCategories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();

        return view('user.documents.upload', compact('categories'));
    }

    public function storeUpload(DocumentRequest $request)
    {
        $user = Auth::user();
        if ($user->upload <= 0) {
            $message = __('uploads.expired_times');

            return back()->with('error', $message);
        } else {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $document = new Document();
            $category = ($request->category == '') ? config('uploads.category_root') : $request->category;
            $url = $this->saveFile($file);
            $attributes = [
                'name' => $request->name,
                'description' => $request->description,
                'url' => $url . $filename,
                'user_id' => $user->id,
                'category_id' => $category,
            ];
            $document->create($attributes);
            $upload = $user->upload - 1;
            $coin = $user->coin + 10;
            $user->update([
                'upload' => $upload,
                'coin' => $coin,
            ]);
            $message = __('uploads.success');

            return back()->with('success', $message);
        }
    }

    public function saveFile(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $path = 'uploads/' . $extension . '/';
        $file->storeAs($path, $filename);

        return $path;
    }

    public function search(Request $request)
    {
        $documents = Document::where('name', 'LIKE', '%' . $request->name . '%')->with('uploadBy')->get();
        $categories = $this->categories;

        return view('user.documents.search', compact('documents', 'categories'));
    }

    public function mark($id)
    {
        $document = Document::findOrFail($id);
        if ($this->authorize('mark', $document)) {
            $userLogin = Auth::user();
            $userLogin->favorites()->attach($document);

            return redirect()->route('user.documents.index');
        }
    }

    public function unmark($id)
    {
        $document = Document::findOrFail($id);
        if ($this->authorize('mark', $document)) {
            $userLogin = Auth::user();
            $userLogin->favorites()->detach($document);

            return redirect()->route('user.documents.index');
        }
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        $author = $document->uploadBy;
        $user = Auth::user();
        if ($user->id != $author->id) {
            if ($user->download_free >= config('user.download_free')) {
                $download_free = $user->dowload_free - config('user.download_free');
                $user->update([
                    'download_free' => $download_free
                ]);
            } elseif ($user->coin >= config('user.coin_least')) {
                $coin = $user->coin - config('user.coin_least');
                $user->update([
                    'coin' => $coin
                ]);
            } else {
                return redirect()->route('buy-coin');
            }
            $user->downloads()->attach($document);
            $coin = $author->coin + config('user.coin_author');
            $author->update([
                'coin' => $coin
            ]);
        }

        return response()->download(public_path($document->url), $document->name);
    }

    public function comment(CommentRequest $request, $id)
    {
        $document = Document::findOrFail($id);
        if ($this->authorize('comment', $document)) {
            $user = Auth::user();
            $user->comments()->attach($document, ['content' => $request->comment]);

            return redirect()->route('user.documents.show', ['document' => $document->id]);
        }
    }

    public function listDocuments($id)
    {
        $category = Category::findOrFail($id);
        $documents = $category->documents;
        $categories = Category::with('categories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();

        return view('user.documents.search', compact('categories', 'documents'));
    }
}
