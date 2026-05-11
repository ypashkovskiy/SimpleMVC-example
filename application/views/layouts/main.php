<?php 
use ItForFree\SimpleMVC\Config;




$User = Config::getObject('core.user.class');

?>
<!DOCTYPE html>
<html>
    
    <?php include('includes/main/head.php'); ?>
    <body> 
        <?php include('includes/main/nav.php'); ?>
        <div class="container">
            <?= $CONTENT_DATA ?>
        </div>
        <?php include('includes/main/footer.php'); ?>
    
      <script src="/JS/ajax-notes-post.js" onload="console.log('Скрипт загружен!')" onerror="alert('Ошибка загрузки скрипта!')"></script>
      <script src="/JS/ajax-notes-get.js" onload="console.log('Скрипт загружен!')" onerror="alert('Ошибка загрузки скрипта!')"></script>
    </body>
</html>

