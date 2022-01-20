<?php
require_once("blog.php");
$blog = new Blog();
$blogs = $_POST;

$blog->blogValidate($blogs);
$blog->blogUpdate($blogs);
?>
<p><a href="/">戻る</a></p>