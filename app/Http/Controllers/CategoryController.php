<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $cateRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->cateRepo->getAll();

        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->cateRepo->getChildCategories();

        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $parentId = ($request->category ?? config('uploads.category_root'));
        $this->cateRepo->create([
            'name' => $request->name,
            'parent_id' => $parentId,
        ]);
        $message = __('category.create_success');

        return redirect(route('admin.categories.index'))->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->cateRepo->getChildCategories();
        $thisCategory = $this->cateRepo->find($id);
        $parent = $thisCategory->parent;

        return view('admin.categories.edit', compact('thisCategory', 'parent', 'categories'));
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
        $category = $this->cateRepo->find($id);
        $this->cateRepo->update($category, [
            'name' => $request->name,
            'parent_id' => $request->category,
        ]);
        $message = __('category.update_success');

        return redirect(route('admin.categories.index'))->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->cateRepo->find($id);
        $status = config('code.server_error');
        $title = __('category.error');
        $message = __('category.delete_error');
        if ($category) {
            $count = $this->cateRepo->countChildCategories($category);
            if ($count > 0) {
                $attribute = [
                    'parent_id' => $category->parent_id,
                ];

                $category_id = [
                    'category_id' => $category->parent_id,
                ];
                $this->cateRepo->updateDocumentsCategory($category, $category_id);
                $this->cateRepo->updateChildCategoriesParent($category, $attribute);
            }
            if ($this->cateRepo->delete($category)) {
                $title = __('category.success');
                $message = __('category.delete_success');
                $status = config('code.success');
            } else {
                $status = config('code.client_error');
            }
        }

        return response()->json([
            'message' => $message,
            'title' => $title,
        ], $status);
    }
}
