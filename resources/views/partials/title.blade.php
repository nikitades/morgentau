<?php
switch (true) {
    case !empty($page) && !empty($page->name):
        $page_title = $page->name;
        break;
    case !empty($title):
        $page_title = $title;
        break;
    default:
        $page_title = env('PROJECT_NAME');
        break;
}
?>
<title>{{ $page_title }}</title>