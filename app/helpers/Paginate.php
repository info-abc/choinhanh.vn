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
			if(isset($_GET['search'])) {
				$url .= '&search='.$_GET['search'];
			}
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
			if(isset($_GET['search'])) {
				$url .= '&search='.$_GET['search'];
			}
			return $this->getPageLinkWrapper($url, $text);
		}
	}

	public function getLinks()
	{
		$html = '';
		// if ($this->currentPage >= 3) {
		// 	if (getDevice() == COMPUTER) {
		// 		$html .= $this->getNormalTextWrapper('...');
		// 	}
			// else {
			// 	$html .= $this->getNormalTextWrapper('');
			// }
		// }
		return $html;
	}

	public function getLastLinks()
	{
		$html = '';
		// if ($this->currentPage <= $this->lastPage - 2) {
		// 	if (getDevice() == COMPUTER) {
		//   		$html .= $this->getNormalTextWrapper('...');
		// 	}
			// else {
		 //  		$html .= $this->getNormalTextWrapper('');
			// }
		// }
		return $html;
	}

	public function getPrevious($text = '&laquo;')
	{
		// If the current page is less than or equal to one, it means we can't go any
		// further back in the pages, so we will render a disabled previous button
		// when that is the case. Otherwise, we will give it an active "status".
		if ($this->currentPage <= 1)
		{
			return $this->getDisabledTextWrapper($text);
		}

		$url = $this->paginator->getUrl($this->currentPage - 1);
		if(isset($_GET['search'])) {
			$url .= '&search='.$_GET['search'];
		}
		return $this->getPageLinkWrapper($url, $text, 'prev');
	}

	public function getLink($page)
	{
		$url = $this->paginator->getUrl($page);
		if(isset($_GET['search'])) {
			$url .= '&search='.$_GET['search'];
		}
		return $this->getPageLinkWrapper($url, $page);
	}

	public function getNext($text = '&raquo;')
	{
		// If the current page is greater than or equal to the last page, it means we
		// can't go any further into the pages, as we're already on this last page
		// that is available, so we will make it the "next" link style disabled.
		if ($this->currentPage >= $this->lastPage)
		{
			return $this->getDisabledTextWrapper($text);
		}

		$url = $this->paginator->getUrl($this->currentPage + 1);
		if(isset($_GET['search'])) {
			$url .= '&search='.$_GET['search'];
		}
		return $this->getPageLinkWrapper($url, $text, 'next');
	}
}