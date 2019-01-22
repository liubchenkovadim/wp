<?php
function testing_all(){
    global $wpdb;
    $table = $wpdb->prefix.'testing';
    $query = "SELECT * FROM $table ORDER  BY id DESC";
    return $wpdb->get_results($query, ARRAY_A);

}

function testing_get($id){
    global $wpdb;
    $table = $wpdb->prefix.'testing';
    $t = "SELECT name, text  FROM $table WHERE id='%d'";
    $query = $wpdb->prepare($t, $id);
    return $wpdb->get_row($query, ARRAY_A);
}

function testing_add($title, $content){
    global $wpdb;
    $title = trim($title);
    $content = trim($content);

    if($title == '' || $content == '')
        return false;
    $table = $wpdb->prefix.'testing';

    $sql = "INSERT INTO $table (name, text) VALUES('%s', '%s') ";
    $query = $wpdb->prepare($sql, $title, $content);
    $result = $wpdb->query($query);

    if ($result === false)
        die('Ошибка БД');

    return true;


}

function testing_edit($id, $title, $content){
    global $wpdb;
    $title = trim($title);
    $content = trim($content);

    if($title == '' || $content == '')
        return false;
    $table = $wpdb->prefix.'testing';

    $sql = "UPDATE $table SET name='%s', text='%s' WHERE id= '%d'";
    $query = $wpdb->prepare($sql, $title, $content, $id);
    $result = $wpdb->query($query);

    if ($result === false)
        die('Ошибка БД');

    return true;

}

function testing_delete($id){
    global $wpdb;
    $table = $wpdb->prefix.'testing';
    $t = "DELETE   FROM $table WHERE id='%d'";
    $query = $wpdb->prepare($t, $id);
    return $wpdb->query($query);


}