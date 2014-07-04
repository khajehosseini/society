<?php

class CostController extends RController
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column2';

/**
* @return array action filters
*/
public function filters()
{
return array(
'rights', // perform access control for CRUD operations
);
}

/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id)
{
$this->render('view',array(
'model'=>$this->loadModel($id),
));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
$model=new Cost;
$block_id	=	$this->getBlockId();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Cost']))
{
$model->attributes=$_POST['Cost'];
$model->block_code	=	$block_id;
$temp				=	($model->date_cheque=='--')?0:$model->date_cheque;
$model->date_cheque	=	jalali_to_gergorian_string($temp	);
if($model->save())
$this->redirect(array('view','id'=>$model->id));
}

$this->render('create',array(
'model'=>$model,
));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Cost']))
{
$model->attributes=$_POST['Cost'];
if($model->save())
$this->redirect(array('view','id'=>$model->id));
}

$this->render('update',array(
'model'=>$model,
));
}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
public function actionDelete($id)
{
if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset($_GET['ajax']))
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
}
else
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

private function getBlockId()
{
	foreach(Yii::app()->session['role']	as $k=>$data){
		if($data->role_code	==	5	){//5 is heabdar
			$block_id	=	$data->block_code;
			break;
		}
	}
	return	$block_id;
}
/**
* Lists all models.
*/
public function actionIndex()
{
$block_id	=	$this->getBlockId();
$dataProvider=new CActiveDataProvider('Cost'	,array(	'criteria'=>array(
															'condition'=>"block_code=$block_id",
															 'order'=>'id DESC',
														)));
$this->render('index',array(
'dataProvider'=>$dataProvider,
));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
$model=new Cost('search');
$block_id	=	$this->getBlockId();
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Cost']))
$model->attributes=$_GET['Cost'];

$this->render('admin',array(
'model'=>$model,'block_id'	=>	$block_id
));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=Cost::model()->findByPk($id);
if($model===null)
throw new CHttpException(404,'The requested page does not exist.');
return $model;
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model)
{
if(isset($_POST['ajax']) && $_POST['ajax']==='cost-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
