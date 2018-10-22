<?php
//show error reporting
ini_set('display errors', 1);
error_reporting(E_ALL);

//home page url
$home_page_url = "http:/localhost/api/";

//page given in URL parameter, default page is one
$page = isset($_GET['page'])?$_GET['page']:1;

//set numberof users per page
$users_per_page = 5;

//calculate for the query LIMIT clause
$from_user_num = ($users_per_page * $page) - $users_per_page;
?>