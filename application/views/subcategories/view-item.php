<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>


<h2><?= $viewcategories->name  ?> </h2>                      

<h2><?= $viewsubcategories->name  ?>
    <span>
        <?= $User->returnIfAllowed("admin/subcategories/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/edit&id=". $viewsubcategories->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/subcategories/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/delete&id=". $viewsubcategories->id)
            .    ">[Удалить]</a>"); ?>
    </span>
    
</h2> 

<p>Описание: <?= $viewsubcategories->description ?></p>