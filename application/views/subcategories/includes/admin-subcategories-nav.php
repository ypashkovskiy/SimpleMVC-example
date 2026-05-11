<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');


//vpre($User->explainAccess("admin/adminusers/index"));
?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/subcategories/index")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/subcategories/index") ?>">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/categories/add")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/subcategories/add") ?>"> + Добавить под категорию</a>
    </li>
    <?php endif; ?>  
</ul>