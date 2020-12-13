<?php

namespace App\ViewComposer;

use Illuminate\View\View;
use Request;

class MasterComposer
{
	public function __construct()
	{
	}
	public function compose(View $view)
	{
		// $data = $view->getData();
		// $value = $this->setting->first();
		// if (!isset($data['og'])) {
		// 	$og = [
		// 		'title' => '',
		// 		'description' => '',
		// 		'keywords' => '',
		// 	];

		// 	$og['title'] = $value->meta_title;
		// 	$og['description'] = $value->meta_description;
		// 	$og['keywords'] = $value->meta_keywords;
		// 	$og['image'] = '';

		// 	$view->with(['og' => $og]);
		// }
	}
}
