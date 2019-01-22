<?php
include_once ('m/testing.php');

$testing = testing_all();

?>
<h2>Отзывы</h2>
<ul>
    <li><a href="<?=$_SERVER['PHP_SELF']?>?page=testing&c=add">Добавить новый отзыв</a> </li>
    <p> Список всех отзывов:</p>
    <?php
    foreach($testing as $op){ ?>
        <li><a href="<?=$_SERVER['PHP_SELF']?>?page=testing&c=edit&id=<?=$op['id']?>"> <?=$op['name']?> </a> </li>
    <?php } ?>
</ul>
