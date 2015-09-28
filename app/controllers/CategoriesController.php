<?php

class CategoriesController extends BaseController
{
	public function __construct() {
		$this->beforeFilter('csrf',array('on' => 'post')); 
	}

	/**
	 * index action: display all the categories along with delete button and a
	 * form with new categories
	 * @return [type] view from categories folder named index and
	 * all the categories from the category's table to the view
	 *
	 * categories is a variable, all() method of Category model
	 */
	public function getIndex() {
		return View::make('categories.index')
			->with('categories',Category::all()); 
	}
	
	/**
	 * create action: when a form is post to
	 * create new category
	 * @return [type] redirect to category's admin page with success message
	 * or if data failes then message, with errors and submitted data back to
	 * the user
	 */
	public function postCreate() {
		$validator = Validator::make(Input::all(), Category::$rules);

		if ($validator->passes()) {
			$category = new Category;
			$category->name = Input::get('name'); // get method return form submitted data 
			$category->save();

			return Redirect::to('admin/categories/index')
				->with('message', 'Category Created'); 
		}
		return Redirect::to('admin/categories/index')
			->with('message', 'Something went wrong')
			->withErrors($validator)
			->withInput(); 
	}
	
	/**
	 * Destroy action to delete category
	 * @return [type] message of success or failure
	 */
	public function postDestroy() {
		// finding the id using category find
		$category = Category::find(Input::get('id'));

		if ($category) {
			$category->delete();
			return Redirect::to('admin/categories/index')
				->with('message', 'Category Deleted'); 
		}
		return Redirect::to('admin/categories/index')
			->with('message', 'Something went wrong, please try again'); 
	}
}