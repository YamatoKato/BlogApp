<?php
require_once("blog.php");
$blog = new Blog();
$blogs = $_POST;

$blog->blogValidate($blogs);
$blog->blogCreate($blogs);
        

?>
<p><a href="/">戻る</a></p>