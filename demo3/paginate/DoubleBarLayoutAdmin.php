<?php 
class DoubleBarLayout implements PageLayout {

	public function fetchPagedLinks($parent, $queryVars) {
	echo "<ul class='paginations'>";
		$currentPage = $parent->getPageNumber();
		$str = "";

		

		//write statement that handles the previous and next phases
	   	//if it is not the first page then write previous to the screen
		if(!$parent->isFirstPage()) {
			$previousPage = $currentPage - 1;
			$str .= "<li class='page_prev'><a href=\"$queryVars$previousPage\"  >&laquo;</a></li>";
		}
		
		if(!$parent->isFirstPage()) {
			if($currentPage>4) {
					$str .= "<li class='page_first'><a href='".$queryVars."1' title='Start' >1...</a> </li> ";
			}
		}

		for($i = $currentPage - 3; $i <= $currentPage + 4; $i++) {
			//if i is less than one then continue to next iteration		
			if($i < 1) {
				continue;
			}
	
			if($i > $parent->fetchNumberPages()) {
				break;
			}
	
			if($i == $currentPage) {
				$str .= "<li  class='current_page'><i>$i</i></li>";
			}
			else {
	$str .= "<li class='page_num'><a href=\"$queryVars$i\"   >$i </a></li>";
			}
			($i == $currentPage + 4 || $i == $parent->fetchNumberPages()) ? $str .= " " : $str .= "";              //determine if to print bars or not
		}//end for

		if (!$parent->isLastPage()) {
			if($currentPage != $parent->fetchNumberPages() && $currentPage != $parent->fetchNumberPages() -3 && $currentPage != $parent->fetchNumberPages() - 4)
			{
				$str .= "<li class='page_last'><a href=\"$queryVars".$parent->fetchNumberPages()."\" title=\"Last\"  >...".$parent->fetchNumberPages()." </a></li>";
			}
		}

		if(!$parent->isLastPage()) {
			$nextPage = $currentPage + 1;
			$str .= "<li class='page_next'><a href=\"$queryVars$nextPage\"   >&raquo;</a></li>";
		}
		return $str;
	}
}
?>
