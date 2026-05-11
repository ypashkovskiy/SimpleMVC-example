<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $addCategoryTitle ?></h2>

<form id="addNote" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/add")?>"> 
    <div class="form-group">
        <label for="title">Название новой категории</label>
        <input type="text" class="form-control" name="name" id="title" placeholder="имя категории">
    </div>
    <div class="form-group">
        <label for="content">Описание</label><br>
        <textarea type="description" name="description" placeholred="описание категории"  value=></textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNewCategory" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>    
