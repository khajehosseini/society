<?php

/**
 * This is the model class for table "{{cost_type}}".
 *
 * The followings are the available columns in table '{{cost_type}}':
 * @property integer $id
 * @property integer $cost_type_mode_code
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Cost[] $costs
 * @property CostTypeMode $costTypeModeCode
 */
class CostType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cost_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cost_type_mode_code, title', 'required'),
			array('cost_type_mode_code', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cost_type_mode_code, title', 'safe', 'on'=>'search'),
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
			'costs' => array(self::HAS_MANY, 'Cost', 'cost_type_code'),
			'costTypeModeCode' => array(self::BELONGS_TO, 'CostTypeMode', 'cost_type_mode_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'cost_type_mode_code' => 'نوع نوع هزينه',
			'title' => 'نوع هزینه',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cost_type_mode_code',$this->cost_type_mode_code);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CostType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
