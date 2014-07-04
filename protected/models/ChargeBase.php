<?php

/**
 * This is the model class for table "{{charge_base}}".
 *
 * The followings are the available columns in table '{{charge_base}}':
 * @property integer $id
 * @property integer $block_code
 * @property integer $month_code
 * @property integer $year_code
 * @property string $amount
 * @property string $description
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Month $monthCode
 * @property Year $yearCode
 * @property Block $blockCode
 * @property ChargeBaseDetail[] $chargeBaseDetails
 */
class ChargeBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{charge_base}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('month_code, year_code, amount', 'required'),
			array('block_code, month_code, year_code', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>255),
			array('block_code,description,create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, block_code, month_code, year_code, amount, description, create_date', 'safe', 'on'=>'search'),
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
			'monthCode' => array(self::BELONGS_TO, 'Month', 'month_code'),
			'yearCode' => array(self::BELONGS_TO, 'Year', 'year_code'),
			'blockCode' => array(self::BELONGS_TO, 'Block', 'block_code'),
			'chargeBaseDetails' => array(self::HAS_MANY, 'ChargeBaseDetail', 'charge_base_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'block_code' => 'Block Code',
			'month_code' => 'ماه',
			'year_code' => 'سال',
			'amount' => 'میزان',
			'description' => 'توضیحات',
			'create_date' => 'تاریخ ایجاد',
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

		$criteria->compare('id',$this->id);
		if($block_id	!=	''	&&	is_numeric($block_id))
			$criteria->compare('block_code',$block_id);
			
		$criteria->compare('month_code',$this->month_code);
		$criteria->compare('year_code',$this->year_code);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChargeBase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
