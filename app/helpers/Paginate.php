<?php 

class Paginate extends Illuminate\Pagination\BootstrapPresenter {

	public function getActivePageWrapper($text)
	{
		return '<li class="current pure-menu-item pagination-button"><a href="" class="pure-menu-link pure-button pure-button-disabled">'.$text.'</a></li>';
	}

	public function getDisabledTextWrapper($text)
	{
		return '<li class="unavailable pure-menu-item pagination-button"><a href="" class="pure-menu-link pure-button-disabled">'.$text.'</a></li>';
	}

	public function getNormalTextWrapper($text)
	{
		return '<li class="unavailable pure-menu-item pagination-button"><a href="" class="pure-menu-link">'.$text.'</a></li>';
	}

	public function getPageLinkWrapper($url, $page, $rel = null)
	{
		return '<li class="pure-menu-item pagination-button"><a href="'.$url.'" class="pure-menu-link pure-button">'.$page.'</a></li>';
	}
	
	public function render()
	{
		if($this->lastPage < 3) {
			$content = $this->getPageRange(1, $this->lastPage); 
		} else {
			if ($this->currentPage == 1) {
				$content = $this->getPageRange(1, $this->currentPage + 2); 
			}
			else if ($this->currentPage >= $this->lastPage) {
				$content = $this->getPageRange($this->currentPage - 2, $this->lastPage); 
			}
			else {
				$content = $this->getPageRange($this->currentPage - 1, $this->currentPage + 1); 
			}
		}
		return $this->getFirst() . $this->getPrevious('<i class="fa fa-angle-left"></i>') . $this->getLinks(). $content . $this->getLastLinks() . $this->getNext('<i class="fa fa-angle-right"></i>').$this->getLast();
	}

	public function getFirst($text = '<i class="fa fa-angle-double-left"></i>')
	{
		if ($this->currentPage <= 1)
		{
			return $this->getDisabledTextWrapper($text);
		}
		else
		{
			$url = $this->paginator->getUrl(1);
			return $this->getPageLinkWrapper($url, $text);
		}
	}

	public function getLast($text = '<i class="fa fa-angle-double-right"></i>')
	{
		if ($this->currentPage >= $this->lastPage)
		{
			return $this->getDisabledTextWrapper($text);
		}
		else
		{
			$url = $this->paginator->getUrl($this->lastPage);

			return $this->getPageLinkWrapper($url, $text);
		}
	}

	public function getLinks()
	{
		$html = '';
		if ($this->currentPage >= 3) {
			if (getDevice() == COMPUTER) {
				$html .= $this->getNormalTextWrapper('...');
			}
			// else {
			// 	$html .= $this->getNormalTextWrapper('');
			// }
		}
		return $html;
	}

	public function getLastLinks()
	{
		$html = '';
		if ($this->currentPage <= $this->lastPage - 2) {
			if (getDevice() == COMPUTER) {
		  		$html .= $this->getNormalTextWrapper('...');
			}
			// else {
		 //  		$html .= $this->getNormalTextWrapper('');
			// }
		}
		return $html;
	}
}