<?php 
use ItForFree\SimpleMVC\Config;
use \ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-categories-nav.php'); ?>

<h2>List categories</h2>

<?php if (!empty($viewCategories)): ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Имя категории</th>
                <th scope="col">Описание</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($viewCategories as $category): ?>
                <tr>
                    <td>
                        <a href="<?= WebRouter::link('admin/categories/index&id=' . $category->id) ?>">
                            <?= htmlspecialchars($category->name) ?>
                        </a>
                    </td>
                    <td>
                        <?= htmlspecialchars($category->description) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>