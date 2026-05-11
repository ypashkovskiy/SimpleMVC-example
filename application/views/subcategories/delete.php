<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $deleteSubCategoryTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/subcategories/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить под категорию?
    
    <input type="hidden" name="id" value="<?=  $deletedSubcategory->id ?>">
    <input type="submit" name="deleteSybCategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>