<?php

class Search2Controller extends BaseController {

	protected $layout;
	
	public function __construct()
	{
		$this->layout = 'layouts.master';
    }
	
	public function showPage()
	{
		$content = View::make('search2');
		$this->layout->content = $content;
		
		return;
	}
	
	
}
