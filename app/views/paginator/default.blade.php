<?php
	$presenter = new Sadeghi85\Extensions\PaginationPresenter($paginator);
?>

@if ($paginator->getLastPage() > 1)
<table class="pagination_links" cellspacing="0" cellpadding="0" align="left">
	<tr>{{ $presenter->render() }}</tr>
</table>
@endif
