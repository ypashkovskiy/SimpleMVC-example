<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?=   $editSubCategoryTitle ?></h2>

<form id="editCategory" method="post" action="<?= $Url::link("admin/subcategories/edit&id=" . $_GET['id'])?>">

<div class="form-group">
    <label for="title">Название категории</label>
    <select class="form-control" name="categories_id" id="title" required>
        <option value="">Выберите категорию</option>
        <?php foreach ($viewcategories as $category): ?>
            <option value="<?= htmlspecialchars($category->id) ?>"
                <?= ($category->id == $viewsubcategories->categories_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category->name) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

    <h5>Sub Category name</h5> 
    <input type="text" name="name" placeholder="name category" required value="<?=  $viewsubcategories->name?>"><br>
    <h5>Sub Category description </h5>
    <textarea type="description" name="description" placeholred="description"   value=><?= $viewsubcategories-> description?></textarea><br>

<input type="hidden" name="id" value="<?= $_GET['id']; ?>">
<input type="submit" name="saveChanges" value="Сохранить">
<input type="submit" name="cancel" value="Назад">
</form>