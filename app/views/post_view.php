<?php

$post_list = 'SELECT * FROM `questions` JOIN themes ON themes.id=theme_id WHERE answer_id>0';
$list = $db->query($post_list);
$post = $list->fetch(PDO::FETCH_NUM);

