<ul>
    @foreach ($pages as $key => $page)
        <?php
        $url = '';
        $target = '';
        $url = $page['url'];
        if ($page['target'] === '') {
            $target = $page['target'];
        }
        ?>
        <li><a href="{!!$url!!}" target="{!! $target !!}">{!!$page['title']!!}</a>{!!$page['upages']!!}</li>
    @endforeach
</ul>
