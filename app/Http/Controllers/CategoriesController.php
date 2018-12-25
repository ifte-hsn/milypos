<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CategoriesTransformer;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Image;
use File;

class CategoriesController extends Controller
{
    /**
     * Show category index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('Read Category', Category::class);
        return view('categories.index');
    }

    /**
     * Get list of users form database
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getCategoriesList(Request $request)
    {
        $this->authorize('Read Category', Category::class);

        $categories = Category::select([
            'categories.id',
            'categories.name',
            'categories.image',
        ]);


        if ($request->has('deleted') && $request->input('deleted') == 'true') {
            $categories = $categories->getDeleted();
        }

        if ($request->has('search') && $request->input('search') != '') {
            $categories = $categories->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 20);

        switch ($request->input('sort')) {
            default:
                $allowed_columns = ['name', 'id'];
                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'id';

                $categories = $categories->orderBy($sort, $order);
                break;
        }

        $total = $categories->count();
        $categories = $categories->skip($offset)->take($limit)->get();

        return (new CategoriesTransformer)->transformCategories($categories, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('Create Category', Category::class);

        $category = new Category();
        return view('categories.edit', compact('category'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('Create Category', Category::class);

        $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'image'
        ]);

        $category = new Category();
        $category->name = $request->input('name');


        // process the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = str_random(25) . "." . $image->getClientOriginalExtension();
            $path = public_path('uploads/categories/' . $file_name);

            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $category->image = $file_name;

        }




        try {
            if ($category->save()) {
                return redirect()->route('category.index')->with('success', trans('categories/message.create.success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('categories/message.error.create'));
        }

        return redirect()->back()->withInput()->withErrors($category->getErrors());

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('Update Category', Category::class);

        if($category =  Category::findOrFail($id)) {
            return view('categories.edit', compact('category'));
        }

        $error = __('categories/message.category_not_found', compact('id'));
        return redirect()->route('users.index')->with('error', $error);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        // Authorize user
        // check if logged in user has the permission to create new data
        $this->authorize('Update Category', Category::class);

        $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'image'
        ]);

        try{
            $category = Category::findOrFail($id);
        } catch(ModelNotFoundException $ex) {
            return redirect()->route('category.index')
                ->with('error', trans('categories/message.category_not_found', compact('id')));
        }


        $category->name = $request->input('name');


        // process the image
        if ($request->hasFile('image')) {

            if($category->image != '') {
                // Delete previous file
                $path = public_path('uploads/categories/'.$category->image);
                File::delete($path);
            }



            $image = $request->file('image');
            $file_name = str_random(25) . "." . $image->getClientOriginalExtension();
            $path = public_path('uploads/categories/' . $file_name);

            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $category->image = $file_name;

        }

        try {
            if ($category->save()) {
                return redirect()->route('category.index')->with('success', trans('categories/message.create.success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('categories/message.error.update'));
        }

        return redirect()->back()->withInput()->withErrors($category->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
