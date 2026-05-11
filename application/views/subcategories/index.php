<?php 
use ItForFree\SimpleMVC\Config;
use \ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-subcategories-nav.php'); ?>

<h2>List subcategories</h2>

<?php if (!empty($viewsubcategories)): ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Имя категории</th>
                <th scope="col">Имя под категории</th>
                <th scope="col">Описание</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($viewsubcategories as $subcategory): ?>
                <tr>

                     
                    <td>
                    <?php
                         $categoryId = $subcategory->categories_id;
                         $categoryName = 'Категория не найдена';

                     foreach ($viewcategories as $category) {
                         if ($category->id == $categoryId) { // предполагаем, что у объекта есть поле `id`
                         $categoryName = $category->name;
                         break;
                         }
                        }

                        echo htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8');
                          ?>
                    </td>

                    <td>
                        <a href="<?= WebRouter::link('admin/subcategories/index&id=' . $subcategory->id) ?>">
                            <?= htmlspecialchars($subcategory->name) ?>
                        </a>
                    </td>
                    <td>
                        <?= htmlspecialchars($subcategory->description) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>