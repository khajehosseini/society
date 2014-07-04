<?php

/**
 * This is the model class for table "{{leaseholder}}".
 *
 * The followings are the available columns in table '{{leaseholder}}':
 * @property integer $id
 * @property integer $status
 * @property integer $unity_code
 * @property integer $user_code
 * @property string $begin_date
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Unity $unityCode
 * @property Users $userCode
 */
class Leaseholder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{leaseholder}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unity_code, user_code, begin_date', 'required'),
			array('status, unity_code, user_code', 'numerical', 'integerOnly'=>true),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, unity_code, user_code, begin_date, end_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'unityCode' => array(self::BELONGS_TO, 'Unity', 'unity_code'),
			'userCode' => array(self::BELONGS_TO, 'User', 'user_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' 			=> 'شناسه',
			'status'		=> 'وضعیت',
			'unity_code'	=> 'واحد',
			'user_code'		=> 'فرد',
			'begin_date'	=> 'تاریخ شروع',
			'end_date'		=> 'تاریخ پایان'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($block_id	=	'')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with	=	'unityCode';
		$criteria->compare('id',$this->id);
		$criteria->compare('status',$this->status);
		$criteria->compare('unity_code',$this->unity_code);
		$criteria->compare('user_code',$this->user_code);
		$criteria->compare('begin_date',$this->begin_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		if($block_id	!=	''	&&	is_numeric($block_id))
			$criteria->compare('block_code',$block_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Leaseholder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
