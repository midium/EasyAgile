@if ($paginator->lastPage() > 1)
<div class="pull-right text-right">
	@if(!isset($show_pages) || $show_pages == true)
	<div class="pages-count">Showing <b><?= $paginator->currentPage() ?></b> of <?= $paginator->lastPage() ?></div>
	@endif
	<ul class="pagination pagination-sm ajax-paginator">
	<li class="{{($paginator->currentPage() <= 1) ? 'disabled' : ''}}">
		@if($paginator->currentPage() != 1)
		<a href="{{ $paginator->url($paginator->currentPage()-1) }}" aria-label="Previous" class="fast-transition">
			<span aria-hidden="true">&laquo;</span>
		</a>
		@else
		<span aria-hidden="true">&laquo;</span>
		@endif
	</li>
	@for ($i = 1; $i <= $paginator->lastPage(); $i++)
	<li class="{{ ($paginator->currentPage() == $i) ? 'active' : '' }}"><a href="{{ $paginator->url($i) }}" class="fast-transition">{{ $i }}</a></li>
	@endfor
	<li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'disabled' : '' }}">
		@if($paginator->currentPage() != $paginator->lastPage())
		<a href="{{ $paginator->url($paginator->currentPage()+1) }}" aria-label="Next" class="fast-transition">
			<span aria-hidden="true">&raquo;</span>
		</a>
		@else
		<span aria-hidden="true">&raquo;</span>
		@endif
	</li>
	</ul>
</div>
 @endif
