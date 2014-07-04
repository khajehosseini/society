<?php

class ChargeController extends RController
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
$block_id	=	$this->getBlockId();
$model=new Charge;

// Uncomment the following line if AJAX validation is needed
$this->performAjaxValidation($model);

if(isset($_POST['Charge']))
{
$model->attributes=$_POST['Charge'];
if($model->save())
$this->redirect(array('view','id'=>$model->id));
}

$this->render('create',array(
'model'=>$model,	'block_id'	=>	$block_id 
));
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id)
{
$block_id	=	$this->getBlockId();
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Charge']))
{
$model->attributes=$_POST['Charge'];
if($model->save())
$this->redirect(array('view','id'=>$model->id));
}

$this->render('update',array(
'model'=>$model,'block_id'	=>	$block_id
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
$dataProvider=new CActiveDataProvider('Charge'	,array(	'criteria'=>array(
															'condition'	=>	"unityCode.block_code=$block_id",
															 'order'	=>	't.id DESC',
															 'with'		=>	'unityCode'
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
$block_id	=	$this->getBlockId();
$model=new Charge('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Charge']))
$model->attributes=$_GET['Charge'];

$this->render('admin',array(
'model'=>$model,'block_id'=>$block_id
));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=Charge::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='charge-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

/**
* Displays expertTypes , use in ajax comnbo expertType  .
*/
public function actionUserCodeGet()
{	
//Leaseholder
	$data1=Householder::model()->with('userCode')->findAll('t.status=:status and   unity_code=:unity_id',  array( ':status' =>  1 , ':unity_id'=> $_POST['unity_id'])); //1 ia active
	$data2=Leaseholder::model()->with('userCode')->findAll('t.status=:status and   unity_code=:unity_id',  array( ':status' =>  1 , ':unity_id'=> $_POST['unity_id'])); //1 ia active
	
	$data1=CHtml::listData($data1,'userCode.id','userCode.username');
	$data2=CHtml::listData($data2,'userCode.id','userCode.username');
	if(!empty($data2)){
		foreach ($data2	as $k=>$v){
			$data1[$k]	=	$v;
		}
	}
	$data		=	$data1;
	
			if(!empty($data))
				echo CHtml::tag	('option', array('value'=>''),CHtml::encode('لطفا انتخاب کنيد'),true);
				
			foreach($data as $value=>$city)  {
						echo CHtml::tag
								('option', array('value'=>$value),CHtml::encode($city),true);
					}   

}

}
