<?php

class LeaseholderController extends RController
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
'rights'
);
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
$model		=	new Leaseholder;
$block_id	=	$this->getBlockId();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Leaseholder']))
{
$model->attributes=$_POST['Leaseholder'];
	$temp				=	($model->begin_date=='--')?0:$model->begin_date;
	$model->begin_date	=	jalali_to_gergorian_string($temp	);
	$temp				=	($model->end_date=='--')?0:$model->end_date;
	$model->end_date	=	($temp	==	0	)?	 0	:	jalali_to_gergorian_string(	$temp);
if($model->save()){
	if(	$model->status	==	1){
		$user_id	=	$model->user_code;
		$unity_id	=	$model->unity_code;
		$id			=	$model->id	;
		$leaseholders	=	Leaseholder::model()->findAll(	array('condition'=>"user_code	=	$user_id	and id !=	$id		and status !=	0"));
		if(!empty($leaseholders)){
			Leaseholder::model()->updateAll(array('status'=>	0),'user_code	="'.$user_id .'" and id != "'.$id.'"	and status !=	0');			
		}
		$leaseholders	=	Leaseholder::model()->findAll(	array('condition'=>"unity_code	=	$unity_id	and id !=	$id	and status !=	0	"));
		if(!empty($leaseholders)){
			Leaseholder::model()->updateAll(array('status'=>	0),	'unity_code	="'.	$unity_id .'"	and id !="'.$id.'"	and status !=	0');
		}
		
		
	}
	$this->redirect(array('view','id'=>$model->id));
}
	}

$this->render('create',array(
'model'=>$model,'block_id'	=>	$block_id
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
$block_id	=	$this->getBlockId();
	// $temp				=	($model->begin_date=='--')?0:$model->begin_date;
	// $model->begin_date	=	jalali_to_gergorian_string($temp	);
	// $temp				=	($model->end_date=='--')?0:$model->end_date;
	// $model->end_date	=	jalali_to_gergorian_string(	$temp);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Leaseholder']))
{
$model->attributes=$_POST['Leaseholder'];
	$temp				=	($model->begin_date=='--')?0:$model->begin_date;
	$model->begin_date	=	jalali_to_gergorian_string($temp	);
	$temp				=	($model->end_date=='--')?0:$model->end_date;
	$model->end_date	=	($temp	==	0	)?	 0	:	jalali_to_gergorian_string(	$temp);
if($model->save()){
	if(	$model->status	==	1){
		$user_id	=	$model->user_code;
		$unity_id	=	$model->unity_code;
		$id			=	$model->id	;
		$leaseholders	=	Leaseholder::model()->findAll(	array('condition'=>"user_code	=	$user_id	and id !=	$id		and status !=	0"));
		if(!empty($leaseholders)){
			Leaseholder::model()->updateAll(array('status'=>	0),'user_code	="'.$user_id .'" and id != "'.$id.'"	and status !=	0');			
		}
		$leaseholders	=	Leaseholder::model()->findAll(	array('condition'=>"unity_code	=	$unity_id	and id !=	$id	and status !=	0	"));
		if(!empty($leaseholders)){
			Leaseholder::model()->updateAll(array('status'=>	0),	'unity_code	="'.	$unity_id .'"	and id !="'.$id.'"	and status !=	0');
		}
	}
	$this->redirect(array('view','id'=>$model->id));
}
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

/**
* Lists all models.
*/
public function actionIndex()
{
$block_id	=	$this->getBlockId();
$dataProvider=new CActiveDataProvider('Leaseholder'	,	array(	'criteria'=>array(
															'condition'=>"block_code=$block_id",
															 'order'=>'t.id DESC',
															'with'=>array('unityCode'),
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
$model=new Leaseholder('search');
$block_id	=	$this->getBlockId();
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Leaseholder']))
$model->attributes=$_GET['Leaseholder'];

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
$model=Leaseholder::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='leaseholder-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}
}
