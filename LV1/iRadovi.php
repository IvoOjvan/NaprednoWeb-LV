<?php
interface iRadovi
{
    public static function create($data);
    public static function read($pdo, $page_number);
    function save($pdo);
}

?>