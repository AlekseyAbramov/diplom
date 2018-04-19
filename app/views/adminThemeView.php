<?php

//Получаем список тем
$sth = $db->query('SELECT * FROM `themes`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $themes[] = $list;
}
$i =0;
foreach ($themes as $theme) {
    $id = $theme['id'];
    $sth = $db->query("SELECT COUNT(*) FROM `questions` WHERE theme_id='$id'");
    $sum[$i]['id'] = $id;
    $sum[$i]['sum'] = implode($sth->fetch(PDO::FETCH_NUM));
    $sthNo = $db->query("SELECT COUNT(*) FROM `questions` WHERE theme_id='$id' AND status='1'");
    $sumNo[$i]['id'] = $id;
    $sumNo[$i]['sum'] = implode($sthNo->fetch(PDO::FETCH_NUM));
    $sthYes = $db->query("SELECT COUNT(*) FROM `questions` WHERE theme_id='$id' AND status='2'");
    $sumYes[$i]['id'] = $id;
    $sumYes[$i]['sum'] = implode($sthYes->fetch(PDO::FETCH_NUM));
    $i++;
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('adminTheme.twig', ['themes' => $themes,
                                       'sum' => $sum,
                                       'sumYes' => $sumYes,
                                       'sumNo' => $sumNo]);

