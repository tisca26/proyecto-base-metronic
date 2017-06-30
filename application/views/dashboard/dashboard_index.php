Hola <?php echo get_attr_session('usr_nombre') . ' - ' . get_attr_session('usr_apellidos'); ?> :D

<br>

Hola
<?php
$obj = (get_attr_session('obj', true));
echo $obj->last;
?>

<pre>
<?php
echo htmlspecialchars($this->menu_manager->generar_menu_db());
?></pre>
