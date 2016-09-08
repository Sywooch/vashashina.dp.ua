<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * RBAC manegement
 */

class RbacController extends Controller
{
       private $_authManager;
 
    public function getHelp()
    {
        return <<<EOD
USAGE
  rbac
DESCRIPTION
  This command generates an initial RBAC authorization hierarchy.
EOD;
    }
    // The command "yii example/create test" will call "actionCreate('test')"
    public function actionInit() {
        
        
      //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if(($this->_authManager=Yii::$app->authManager)===null)
        {
               echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
            echo "If you already added 'authManager' component in application configuration,\n";
            echo "please quit and re-enter the yiic shell.\n";
            return;
        }  
        
//provide the oportunity for the use to abort the request
        echo "This command will create three roles: Admin, Manager, and Customer and the following premissions:\n";
        echo "create, read, update and delete user\n";
        echo "create, read, update and delete product\n";
        echo "create, update and delete pages\n";
        echo "create, update and delete news\n";
        echo "Would you like to continue? [Yes|No] ";
       
//check the input from the user and continue if they indicated yes to the above question
        if(!strncasecmp(trim(fgets(STDIN)),'y',1)) 
        {
//first we need to remove all operations, roles, child relationship and assignments
          
//create the lowest level operations for users
         $auth = Yii::$app->authManager;
       

        // add "createProduct" permission
        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Добавить Товар';
        $auth->add($createProduct);
        
            // add "updateProduct" permission
        $updateProduct = $auth->createPermission('updateProduct');
        $updateProduct->description = 'Обновить Товар';
        $auth->add($updateProduct);
        
            // add "deleteProduct" permission
        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Удалить Товар';
        $auth->add($deleteProduct);
        
             // add "менеджер" role and give this role the "createPost" permission
        $manager = $auth->createRole('менеджер');
        $auth->add($manager);
        $auth->addChild($manager, $createProduct);
         $auth->addChild($manager, $updateProduct);
          $auth->addChild($manager, $deleteProduct);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);
       
        
             //provide a message indicating success
             echo "Authorization hierarchy successfully generated.";
             } // end if Y
    }
    // The command "yii example/index city" will call "actionIndex('city', 'name')"
    // The command "yii example/index city id" will call "actionIndex('city', 'id')"
    public function actionIndex($category, $order = 'name') { }

    // The command "yii example/add test" will call "actionAdd(['test'])"
    // The command "yii example/add test1,test2" will call "actionAdd(['test1', 'test2'])"
    public function actionAdd(array $name) { 
        
    }
    public function actionRemoveall(){
         $auth = Yii::$app->authManager;
          $auth->removeAll();
          echo "All roles and permissions cleared!!!";
    }
}/*end of Controller*/