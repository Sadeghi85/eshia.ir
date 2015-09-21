<?php namespace Sadeghi85\Extensions;

class Request extends \Illuminate\Http\Request {
	
	/**
	 * Get the current path info for the request.
	 *
	 * @return string
	 */
    public function path()
	{
		$pattern = trim($this->getPathInfo(), '/');
		
		if (false === strpos($pattern, '.')) {
			$pattern = str_replace('_', ' ', $pattern);
		}
		
		return $pattern == '' ? '/' : $pattern;
	}
	
	/**
	 * Retrieve an input item from the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return string
	 */
	public function input($key = null, $default = null)
	{
		$input = $this->getInputSource()->all() + $this->query->all();

		return array_get(str_replace('_', ' ', $input), $key, $default);
	}
	
	/**
	 * Get a segment from the URI (1 based index).
	 *
	 * @param  string  $index
	 * @param  mixed   $default
	 * @return string
	 */
	public function segment($index, $default = null)
	{
		return array_get($this->segments(), $index, $default);
	}

	/**
	 * Get all of the segments for the request path.
	 *
	 * @return array
	 */
	public function segments()
	{
		$segments = explode('/', str_replace('_', ' ', urldecode($this->path())));
		
		$segments = array_values(array_filter($segments, function($v) { return $v != ''; }));
		
		array_unshift($segments, '');
		unset($segments[0]);
		
		return $segments;
	}
	
	/**
	 * Get the URL (no query string) for the request.
	 *
	 * @return string
	 */
	public function url()
	{
		$url = $this->getUri();
		
		$url = rtrim(preg_replace('/\?.*/', '', $url), '/');
		
		$url = str_replace('"', '%22', $url);
		
		return $url;
	}

}