<?php

/**
 * This is the model class for table "{{cost_unity}}".
 *
 * The followings are the available columns in table '{{cost_unity}}':
 * @property integer $id
 * @property integer $cost_code
 * @property integer $user_code
 * @property integer $unity_code
 * @property string $amount
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Cost $costCode
 * @property Unity $unityCode
 * @property Users $userCode
 */
class CostUnity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cost_unity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cost_code, user_code, unity_code, amount, create_date', 'required'),
			array('cost_code, user_code, unity_code', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cost_code, user_code, unity_code, amount, create_date', 'safe', 'on'=>'search'),
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
			'costCode' => array(self::BELONGS_TO, 'Cost', 'cost_code'),
			'unityCode' => array(self::BELONGS_TO, 'Unity', 'unity_code'),
			'userCode' => array(self::BELONGS_TO, 'Users', 'user_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cost_code' => 'Cost Code',
			'user_code' => 'User Code',
			'unity_code' => 'Unity Code',
			'amount' => 'میزان',
			'create_date' => 'Create Date',
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
	public function search($unity_id	=	''	)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cost_code',$this->cost_code);
		$criteria->compare('user_code',	Yii::app()->user->id	);
		$criteria->compare('unity_code',$unity_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CostUnity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
