<?php namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Term\TermRepository;

class TermsController extends Controller
{
	/**
	 * @var TermRepository
	 */
	private $terms;

	public function __construct(TermRepository $terms)
	{
		$this->terms = $terms;
	}

	public function categories()
	{
		return $this->terms->getCategories();
	}

	public function store()
	{
		return $this->terms->createCategory(\Request::get('term'));
	}
}