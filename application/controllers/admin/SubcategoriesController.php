<?php
namespace application\controllers\admin;
use application\models\Categories;
use application\models\Subcategories;

use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller notes
 * 
 * 
 */

class SubcategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Subcategories = new Subcategories();

        $Categories = new Categories();

        $subcategoriesId = $_GET['id'] ?? null;
        
        if ($subcategoriesId) { // если указан конктреный пользователь
            $viewsubcategories = $Subcategories->getById($_GET['id']);
            $viewcategories = $Categories->getById($viewsubcategories->categories_id);
            $this->view->addVar('viewsubcategories', $viewsubcategories);
            $this->view->addVar('viewcategories', $viewcategories);
            $this->view->render('subcategories/view-item.php');
        } else { // выводим полный список
            
            $viewsubcategories = $Subcategories->getList()['results'];
            $viewcategories = $Categories->getList()['results'];
            $this->view->addVar('viewsubcategories', $viewsubcategories);
            $this->view->addVar('viewcategories', $viewcategories);
            $this->view->render('subcategories/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewSubCategory'])) {
                $Subcategory = new Subcategories();
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->insert(); 
                $this->redirect($Url::link("admin/subcategories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        }
        else {
            
            $addSubCategoryTitle = "Добавление новой под категории";
            $this->view->addVar('addSubCategoryTitle', $addSubCategoryTitle);
            
            $Categories = new Categories();

            $viewcategories = $Categories->getList()['results'];
            $this->view->addVar('viewcategories', $viewcategories);
            
            $this->view->render('subcategories/add.php');
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
                 $Subcategory = new Subcategories();
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->update(); 
                $this->redirect($Url::link("admin/subcategories/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index&id=$id"));
            }
        }
        else {
            $Categories = new Categories();
            $viewcategories= $Categories->getList()['results'];
            
            $editSubCategoryTitle = "Редактирование под категории";

           
            $this->view->addVar('viewcategories', $viewcategories);
            $this->view->addVar('editSubCategoryTitle', $editSubCategoryTitle);


            $Subcategories = new Subcategories();
            $viewsubcategories = $Subcategories->getById($_GET['id']);
            $this->view->addVar('viewsubcategories', $viewsubcategories);
           
            
            $this->view->render('subcategories/edit.php');   
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
            if (!empty($_POST['deleteSybCategory'])) {
                $Subcategory = new Subcategories();
                $newSubcategory = $Subcategory->loadFromArray($_POST);
                $newSubcategory->delete();
                
                $this->redirect($Url::link("admin/subcategories/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/edit&id=$id"));
            }
        }
        else {
            
            $Subcategory = new Subcategories();
            $deletedSubcategory = $Subcategory->getById($id);
            $deleteSubCategoryTitle = "Удалить под категорию?";
            
            $this->view->addVar('deleteSubCategoryTitle', $deleteSubCategoryTitle);
            $this->view->addVar('deletedSubcategory', $deletedSubcategory);
            
            $this->view->render('subcategories/delete.php');
        }
    }
    
    
}