<?php

/**
 * This is the model class for table "{{unity}}".
 *
 * The followings are the available columns in table '{{unity}}':
 * @property integer $id
 * @property string $name
 * @property integer $block_code
 * @property string $elect_meter_num
 * @property integer $meter
 * @property integer $stage
 *
 * The followings are the available model relations:
 * @property Charge[] $charges
 * @property CostUnity[] $costUnities
 * @property Householder[] $householders
 * @property Leaseholder[] $leaseholders
 * @property Block $blockCode
 */
class Unity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{unity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, block_code, elect_meter_num, meter, stage', 'required'),
			array('block_code, meter, stage', 'numerical', 'integerOnly'=>true),
			array('name, elect_meter_num', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, block_code, elect_meter_num, meter, stage', 'safe', 'on'=>'search'),
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
			'charges' => array(self::HAS_MANY, 'Charge', 'unity_code'),
			'costUnities' => array(self::HAS_MANY, 'CostUnity', 'unity_code'),
			'householders' => array(self::HAS_MANY, 'Householder', 'unity_code'),
			'leaseholders' => array(self::HAS_MANY, 'Leaseholder', 'unity_code'),
			'blockCode' => array(self::BELONGS_TO, 'Block', 'block_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'name' => 'شماره واحد',
			'block_code' => 'بلوک',
			'elect_meter_num' => 'شماره کنتور برق',
			'meter' => 'متراژ خانه',
			'stage' => 'طبقه',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('block_code',$this->block_code);
		$criteria->compare('elect_meter_num',$this->elect_meter_num,true);
		$criteria->compare('meter',$this->meter);
		$criteria->compare('stage',$this->stage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Unity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
