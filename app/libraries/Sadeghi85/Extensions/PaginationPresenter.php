<?php namespace Sadeghi85\Extensions;

class PaginationPresenter extends \Illuminate\Pagination\Presenter
{

    public function getActivePageWrapper($text)
    {
        return '<td class="current-page">'.$text.'</td>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<td class="unavailable">'.$text.'</td>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        return '<td><a href="'.$url.'">'.$page.'</a></td>';
    }
	
	public function render()
	{
		if ($this->currentPage > 5)
		{
			$content = $this->getPageRange($this->currentPage - 5, min($this->currentPage + 4, $this->lastPage));
		}
		else
		{
			$content = $this->getPageRange(1, min(10, $this->lastPage));
		}
		
		return $this->getPrevious().$content.$this->getNext();
	}
	
	
}