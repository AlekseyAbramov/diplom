<?php
// Подключаемся к базе данных
require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'db_connect.php';
$menu_list = "SELECT `theme` FROM `themes`";
$list = $db->query($menu_list);
while ($row = $list->fetch(PDO::FETCH_NUM)):
?>
<li><a href="#basics"><?php echo implode($row) ?></a></li>
<?php endwhile; ?>
