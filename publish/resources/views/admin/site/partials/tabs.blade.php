<div class="page-header clearfix" style="margin-top: 0;">
    <h1 class="pull-left" style="margin-top: 0;">Site Settings</h1>
</div>

<ul class="nav panel-nav">
    <li role="presentation" @if($tab == 'edit') class="active" @endif><a href="{{ route('fabric::site.edit') }}">Settings</a></li>
    <li role="presentation" @if($tab == 'domains') class="active" @endif><a href="{{ route('fabric::domain.index') }}">Domains</a></li>
    <li role="presentation" @if($tab == 'redirects') class="active" @endif><a href="{{ route('fabric::redirect.index') }}">Redirects</a></li>
</ul>