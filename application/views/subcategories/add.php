<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $addSubCategoryTitle ?></h2>

<form id="addSubCategory" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/add")?>"> 
    
   <div class="form-group">
     <label for="title">Название категории</label>
     <select class="form-control" name="categories_id" id="title" required>
        <option value="">Выберите категорию</option>
        <?php foreach ($viewcategories as $category): ?>
            <option value="<?= htmlspecialchars($category->id) ?>">
                <?= htmlspecialchars($category->name) ?>
            </option>
        <?php endforeach; ?>
     </select>
    </div>

   <div class="form-group">
        <label for="title">Название новой под категории</label>
        <input type="text" class="form-control" name="name" id="title" required placeholder="имя под категории">
    </div>
    <div class="form-group">
        <label for="content">Описание</label><br>
        <textarea type="description" name="description" placeholred="описание под категории"  value=></textarea>
    </div>
    <input type="submit" class="btn btn-primary" name="saveNewSubCategory" value="Сохранить">
    <input type="submit" class="btn" name="cancel" value="Назад">
</form>   