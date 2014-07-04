<?php

class AdminController extends RController
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
			'rights'
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		if(!UserModule::isAdmin()) {
			if($profile->user_id==1) $this->redirect(array('admin'));
		}

		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				// print_r($model);
				// die();
				$model->save();
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	public function actionRoleManage(){
		Yii::app()->session['user_id']	=	(isset($_GET['id']))	?	$_GET['id']	:	Yii::app()->session['user_id'];
		$model = UserRole::model()->findAll('user_code=:user_id'	,	array('user_id'	=>	Yii::app()->session['user_id']));
		$modelS = new UserRole;
		$this->render('role_manage',array('model'=>$model	,'modelS'	=>	$modelS	,		'user_id'	=>	Yii::app()->session['user_id']		)	);
	}
	public function actionAssginRole(){
		$itemname	=	array();
		$itemname[1]	=	'mostager'	;	
		$itemname[2]	=	'sahebkhaneh'	;	
		$itemname[3]	=	'bazress'	;	
		$itemname[4]	=	'manage_block'	;	
		$itemname[5]	=	'accountant'	;	
		
		if	(	$_POST['role_id']	==	3	|| $_POST['role_id']	==	4	||	$_POST['role_id']	==	5){
			if($_POST['block_code']	!=	''){
				$check	=	UserRole::model()->find('user_code=:userCode	and role_code=:roleCode', array(':userCode'=>$_POST['user_id']	,':roleCode'=>$_POST['role_id']	));
				if(!$check){
						$model= new UserRole;
						$model->user_code	=	$_POST['user_id'];
						$model->role_code	=	$_POST['role_id'];
						$model->block_code	=	$_POST['block_code'];
						$model->save();
						$modelAuth	= new Authassignment;
						
						$modelAuth->itemname	=	$itemname[$_POST['role_id']];   
						$modelAuth->userid		=	$_POST['user_id'];
						$modelAuth->save();
						
					
					}else{
						echo 'exist';
					}
			}else{
				echo 'No_Block';
			}
		}else{
			$check	=	UserRole::model()->find('user_code=:userCode	and role_code=:roleCode', array(':userCode'=>$_POST['user_id']	,':roleCode'=>$_POST['role_id']	));
			if(!$check){
					$model= new UserRole;
					$model->user_code	=	$_POST['user_id'];
					$model->role_code	=	$_POST['role_id'];
					$model->save();
					
					$modelAuth	= new Authassignment;
					$modelAuth->itemname	=	$itemname[$_POST['role_id']];   
					$modelAuth->userid		=	$_POST['user_id'];
					$modelAuth->save();
				}else{
					echo 'exist';
				}
			
		
		}
	}
	public function actionDeleteAssginRole(){
		$row	=	UserRole::model()->find('user_code=:userCode	and role_code=:roleCode', array(':userCode'=>$_GET['user_id']	,':roleCode'=>$_GET['role_id']	));
		$row->delete();
		$itemname	=	array();
		$itemname[1]	=	'mostager'	;	
		$itemname[2]	=	'sahebkhaneh'	;	
		$itemname[3]	=	'bazress'	;	
		$itemname[4]	=	'manage_block'	;	
		$itemname[5]	=	'accountant'	;
		$row	=	Authassignment::model()->find('userid=:userCode	and itemname=:roleCode', array(':userCode'=>$_GET['user_id']	,':roleCode'=>$itemname[$_GET['role_id']]	));
		$row->delete();		
		
	}
	
}