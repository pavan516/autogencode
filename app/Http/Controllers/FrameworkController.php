<?php

# Namespace
namespace App\Http\Controllers;

# Models
use App\Project;

/**
 * Framework Controller
 */
class FrameworkController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * PROJECT : CODEIGNITER
	 * INFO : This method is called after creating tables.
	 *
	 * @return  codeigniter framework view.
	 */
	public function codeigniter($project_uuid)
	{
		# Fetch single project
		$project = (new Project())->arrayToJson($project_uuid);

		return view('framework.codeigniter')->with('project', $project);
	}

	/**
	 * PROJECT : LARAVEL
	 * INFO : This method is called after creating tables.
	 *
	 * @return  laravel framework view.
	 */
	public function laravel($project_uuid)
	{
		# Fetch single project
		$project = (new Project())->arrayToJson($project_uuid);

		return view('framework.laravel')->with('project', $project);
	}

	/**
	 * PROJECT : NODEJS (EXPRESS - MYSQL)
	 * INFO : This method is called after creating tables.
	 *
	 * @return  express_mysql framework view.
	 */
	public function expressMysql($project_uuid)
	{
		# Fetch single project
		$project = (new Project())->arrayToJson($project_uuid);

		# Return to view
		return view('framework.express_mysql')->with('project', $project);
	}

}
