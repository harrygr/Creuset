<?php namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Repositories\Term\TermRepository;
use Creuset\Http\Requests\CreateTermRequest;

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

	public function tags()
	{
		return $this->terms->getTags();
	}

	public function storeCategory(CreateTermRequest $request)
	{
		return $this->terms->createCategory($request->get('term'));
	}
}