<?php namespace Admin;

use Temoa\Command\Dependency\ListCommand;
use Temoa\Command\Dependency\CreateCommand;
use Temoa\Command\Dependency\ReadCommand;
use Temoa\Command\Dependency\UpdateCommand;

use Temoa\Command\PaginateSortedSanitizer;
use BaseController, View, Flash, Redirect;
use Request;

class DependenciesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admin/dependencies
	 *
	 * @return Response
	 */
	public function index()
	{
		$input = Request::only('sort', 'direction', 'page', 'size', 'search');

		$data = $this->execute(ListCommand::class, $input, [
			PaginateSortedSanitizer::class
		]);

		$dependencies = getPaginator($data);

		return View::make('admin.dependencies.index', compact('dependencies'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/dependencies/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.dependencies.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin/dependencies
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Request::only('name', 'responsable');

		$dependency = $this->execute(CreateCommand::class);

		Flash::success(sprintf('La dependencia %s fue creada con éxito!', $dependency->name), $input);

		return Redirect::action('Admin\DependenciesController@index');
	}

	/**
	 * Display the specified resource.
	 * GET /admin/dependencies/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dependency = $this->execute(ReadCommand::class, compact('id'));

		return View::make('admin.dependencies.show', compact('dependency'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /admin/dependencies/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dependency = $this->execute(ReadCommand::class, compact('id'));

		return View::make('admin.dependencies.edit', compact('dependency'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /admin/dependencies/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_merge(compact('id'), Request::only('name', 'responsable'));

		$dependency = $this->execute(UpdateCommand::class, $input);

		Flash::success(sprintf('La dependencia %s fue editada con éxito!', $dependency->name), $input);

		return Redirect::action('Admin\DependenciesController@index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /admin/dependencies/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}