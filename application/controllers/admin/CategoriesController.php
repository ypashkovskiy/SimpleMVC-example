<?php
namespace application\controllers\admin;
use application\models\Categories;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller notes
 * 
 * 
 */

class CategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Categories = new Categories();

        $categoriesId = $_GET['id'] ?? null;
        
        if ($categoriesId) { // если указан конктреный пользователь
            $viewCategories = $Categories->getById($_GET['id']);
            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->render('categories/view-item.php');
        } else { // выводим полный список
            
            $viewCategories = $Categories->getList()['results'];
            $this->view->addVar('viewCategories', $viewCategories);
            $this->view->render('categories/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewCategory'])) {
                $Category = new Categories();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->insert(); 
                $this->redirect($Url::link("admin/categories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $addCategoryTitle = "Добавление новой категории";
            $this->view->addVar('addCategoryTitle', $addCategoryTitle);
            
            $this->view->render('categories/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Category = new Categories();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->update();
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            }
        }
        else {
            $Category = new Categories();
            $viewCategory = $Category->getById($id);
            
            $editCategoryTitle = "Редактирование категории";
           
            $this->view->addVar('viewCategory', $viewCategory);
            $this->view->addVar('editCategoryTitle', $editCategoryTitle);
           
            
            $this->view->render('categories/edit.php');   
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Categories();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->delete();
                
                $this->redirect($Url::link("admin/categories/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/edit&id=$id"));
            }
        }
        else {
            
            $Category = new Categories();
            $deletedCategory = $Category->getById($id);
            $deleteCategoryTitle = "Удалить категорию?";
            
            $this->view->addVar('deleteCategoryTitle', $deleteCategoryTitle);
            $this->view->addVar('deletedCategory', $deletedCategory);
            
            $this->view->render('categories/delete.php');
        }
    }
    
    
}