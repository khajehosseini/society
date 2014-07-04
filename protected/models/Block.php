<?php

/**
 * This is the model class for table "{{block}}".
 *
 * The followings are the available columns in table '{{block}}':
 * @property integer $id
 * @property string $name
 * @property integer $municipality_code
 * @property string $sort_number
 * @property string $gas_meter_num
 * @property string $water_meter_num
 * @property string $common_elect_meter_num
 * @property integer $count_unity
 *
 * The followings are the available model relations:
 * @property Municipality $municipalityCode
 * @property Cost[] $costs
 * @property Income[] $incomes
 * @property Unity[] $unities
 */
class Block extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{block}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, municipality_code, sort_number, gas_meter_num, water_meter_num, common_elect_meter_num, count_unity', 'required'),
			array('municipality_code, count_unity', 'numerical', 'integerOnly'=>true),
			array('name, sort_number, gas_meter_num, water_meter_num, common_elect_meter_num', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, municipality_code, sort_number, gas_meter_num, water_meter_num, common_elect_meter_num, count_unity', 'safe', 'on'=>'search'),
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
			'municipalityCode' => array(self::BELONGS_TO, 'Municipality', 'municipality_code'),
			'costs' => array(self::HAS_MANY, 'Cost', 'block_code'),
			'incomes' => array(self::HAS_MANY, 'Income', 'block_code'),
			'unities' => array(self::HAS_MANY, 'Unity', 'block_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'name' => 'نام بلوک',
			'municipality_code' => 'شهرداری',
			'sort_number' => 'تعداد طبقات',
			'gas_meter_num' => 'شماره کنتور گاز',
			'water_meter_num' => 'شماره کنتور آب',
			'common_elect_meter_num' => 'شماره کنتور برق مشترک',
			'count_unity' => 'تعداد واحد',
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
		$criteria->compare('municipality_code',$this->municipality_code);
		$criteria->compare('sort_number',$this->sort_number,true);
		$criteria->compare('gas_meter_num',$this->gas_meter_num,true);
		$criteria->compare('water_meter_num',$this->water_meter_num,true);
		$criteria->compare('common_elect_meter_num',$this->common_elect_meter_num,true);
		$criteria->compare('count_unity',$this->count_unity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Block the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
