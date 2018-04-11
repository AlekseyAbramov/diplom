<form method="POST">
    <input type="text" name="name" placeholder="Имя" />
    <input type="text" name="email" placeholder="e-mail" />
    <label for="theme">Тема вопроса</label>
        <select name="sort_by">
            <?php 
            $list = $db->query($menu_list);
            while ($row = $list->fetch(PDO::FETCH_NUM)): 
            ?>
            <option value="date_added"><?php echo implode($row) ?></option>
            <?php endwhile; ?>
        </select>
    <input type="submit" name="theme" value="Отправить" />
</form>
<?php
// put your code here
?>
