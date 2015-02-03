<?php

class CategoriesController extends BaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $category;

	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($category_slug)
	{
		$categories = Category::all();
		$cat_id = 0;

		foreach($categories as $category){
			if($category->name == $category_slug || strtolower($category->name) == $category_slug){
				$cat_id = $category->id;
				break;
			}
		}

		$data = array(
			'media' => Media::where('active', '=', 1)->where('category_id', '=', $cat_id)->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page')),
			);

		return View::make('home', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Category::$rules);

		if ($validation->passes())
		{
			$this->category->create($input);

			return Redirect::to('admin?section=categories')->with(array('note' => Lang::get('lang.new_category_success'), 'note_type' => 'success'));;
		}

		return Redirect::to('admin?section=categories')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = $this->category->findOrFail($id);

		return View::make('categories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = $this->category->find($id);

		if (is_null($category))
		{
			return Redirect::route('categories.index');
		}

		return View::make('categories.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Category::$rules);

		if ($validation->passes())
		{
			$category = $this->category->find($id);
			$category->update($input);

			return Redirect::to('admin?section=categories')->with(array('note' => Lang::get('lang.update_success'), 'note_type' => 'success'));;
		}

		return Redirect::to('admin?section=categories', $id)
			->withInput()
			->withErrors($validation)
			->with('message', Lang::get('lang.validation_errors'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$category = Category::find($id);

		$media = Media::where('category_id', '=', $id)->get();
		foreach($media as $single_media){
			$single_media->category_id = 1;
			$single_media->save();
		}
		$category->delete();

		return Redirect::to('admin?section=categories')->with(array('note' => Lang::get('lang.delete_success'), 'note_type' => 'success'));
	}

}
