<div class="page-header clearfix" style="margin-top: 0;">
    <h1 class="pull-left" style="margin-top: 0;">Edit Page</h1>

    <a href="{{ route('fabric::page.create') }}" class="btn btn-default btn-lg pull-right">Create Page</a>
</div>

<ul class="nav panel-nav">
    <li role="presentation" @if($tab == 'edit') class="active" @endif><a href="{{ route('fabric::page.edit', $page->uuid) }}">Content</a></li>
    <li role="presentation" @if($tab == 'slideshow') class="active" @endif><a href="{{ route('fabric::page.slideshow', $page->uuid) }}">Slideshow</a></li>
</ul>