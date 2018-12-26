<?php

namespace App\Http\Controllers;

use App\Http\Transformers\CategoriesTransformer;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Image;
use File;
use Input;

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
     * Get list of categories form database
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
            'categories.deleted_at',
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

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $category->image = $file_name;
            } else {
                $image->move(app('categories_upload_path'), $file_name);
            }

        }

        try {
            if ($category->save()) {
                return redirect()->route('category.index')->with('success', __('categories/message.create.success'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return Redirect::route('category.edit', ['id' => $id]);
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
        return redirect()->route('category.index')->with('error', $error);
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
        $this->authorize('Update Category', Category::class);

        $request->validate([
            'name' => 'required',
            'image' => 'image'
        ]);

        try{
            $category = Category::findOrFail($id);
        } catch(ModelNotFoundException $ex) {
            return redirect()->route('category.index')
                ->with('error', __('categories/message.category_not_found', compact('id')));
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

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $category->image = $file_name;
            } else {
                $image->move(app('categories_upload_path'), $file_name);
            }

        }

        try {
            if ($category->save()) {
                return redirect()->route('category.index')->with('success', __('categories/message.create.success'));
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('Delete Category', Category::class);

        try {
            $category = Category::findOrFail($id);
            $category->delete();
            // Prepare the success message
            $success = __('categories/message.success.delete');

            return redirect()->route('category.index')->with('success', $success);
        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            $error = __('categories/message.category_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('category.index')->with('error', $error);
        }
    }

    /**
     * Restore Deleted Category
     * @param int $id ID of the user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($id = null) {
        // Authorize user
        // check if logged in user has the permission to restore user
        // Any user with permission "Create Category" can restore data.
        $this->authorize('Create Category', Category::class);

        if(!$category = Category::onlyTrashed()->find($id)) {
            return redirect()->route('category.index')->with('error', __('category/message.category_not_found', ['id'=>$id]));
        }

        // Restore the user
        if ($category->withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('category.index')->with('success', __('category/message.success.restored'));
        }

        return redirect()->route('category.index')->with('error', __('category/message.error.could_not_restore'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkEdit(Request $request)
    {
        $this->authorize(['Update Category', 'Delete Category'], Category::class);

        if ($request->has('ids') && (count($request->input('ids')) > 0)) {
            $categories_raw_array = array_keys(Input::get('ids'));

            $categories = Category::whereIn('id', $categories_raw_array)->get();

            if($request->input('bulk_actions') == 'edit') {
                return view('categories.bulk-edit', compact('categories'));
            }
            return view('categories.confirm-bulk-delete',compact('categories'));
        }

        return redirect()->back()->with('error', 'category/message.no_user_selected');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function postBulkSave(Request $request)
    {
        $this->authorize(['Update Category', 'Delete Category'], Category::class);

        if (!$request->has('ids') || count($request->input('ids')) == 0 ) {
            return redirect()->route('category.index')->with('error', __('categories/message.no_category_selected'));
        } else {
            $categories_raw_array = Input::get('ids');

            $categories = Category::whereIn('id', $categories_raw_array)->get();

            foreach ($categories as $category) {
                $category->delete();
            }

            return redirect()->route('category.index')->with('success', __('categories/message.success.selected_user_deleted'));
        }
    }

    /**
     * Export category as csv
     * 
     * @return StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function exportAsCsv() {
        $this->authorize('Read Category', Category::class);
        \Debugbar::disable();

        $response = new StreamedResponse(function() {
            // Open output steam
            $handle = fopen('php://output', 'w');
            Category::orderBy('created_at', 'desc')->chunk(500, function ($categories) use ($handle) {
                $headers = [
                    // strtolower to prevent Excel from trying to open it as a SYSLK file
                    strtolower(__('general.id')),
                    __('users/table.name'),
                    __('general.created_at'),
                ];

                fputcsv($handle, $headers);

                foreach ($categories as $category) {


                    $values = [
                        $category->id,
                        $category->name,
                        $category->created_at,
                    ];

                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="categories-'.date('Y-m-d-his').'.csv"',
        ]);
        return $response;
    }
}
