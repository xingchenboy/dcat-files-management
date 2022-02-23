<ol class="breadcrumb" style="margin-bottom: 10px;">

    <li><a href="{{ admin_route('media-index') }}"><i class="fa fa-th-large"></i> </a></li>

    @foreach($nav as $item)
        <li><span style="margin: 0 6px">/</span><a href="{{ $item['url'] }}"> {{ $item['name'] }}</a></li>
    @endforeach
</ol>
