<?php

/**
 * This is the model class for table "{{cost}}".
 *
 * The followings are the available columns in table '{{cost}}':
 * @property integer $id
 * @property integer $block_code
 * @property string $description
 * @property integer $cost_type_code
 * @property integer $amount_sharje
 * @property integer $amount_income
 * @property integer $amount_unity
 * @property integer $sharje
 * @property integer $income
 * @property integer $unity
 * @property integer $unity_status
 * @property integer $payment_code
 * @property string $transaction_num
 * @property string $date_cheque
 * @property integer $bank_code
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Block $blockCode
 * @property CostType $costTypeCode
 * @property Payment $paymentCode
 * @property Bank $bankCode
 * @property CostUnity[] $costUnities
 */
class Cost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cost}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('block_code, description, cost_type_code,  , payment_code', 'required'),
			array('block_code, cost_type_code, unity_status, payment_code, bank_code', 'numerical', 'integerOnly'=>true),
			array('transaction_num', 'length', 'max'=>255),
			array('create_date,date_cheque	,	 amount_sharje, amount_income, amount_unity, sharje, income, unity', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, block_code, description, cost_type_code, amount_sharje, amount_income, amount_unity, sharje, income, unity, unity_status, payment_code, transaction_num, date_cheque, bank_code, create_date', 'safe', 'on'=>'search'),
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
			'blockCode' => array(self::BELONGS_TO, 'Block', 'block_code'),
			'costTypeCode' => array(self::BELONGS_TO, 'CostType', 'cost_type_code'),
			'paymentCode' => array(self::BELONGS_TO, 'Payment', 'payment_code'),
			'bankCode' => array(self::BELONGS_TO, 'Bank', 'bank_code'),
			'costUnities' => array(self::HAS_MANY, 'CostUnity', 'cost_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'block_code' => 'بلوک',
			'description' => 'شرح',
			'cost_type_code' => 'نوع هزينه',
			'amount_sharje' => 'میزانی که از شارژ خرج شود',
			'amount_income' => 'میزانی که از درآمد خرج شود',
			'amount_unity' => 'میزانی که از  واحدها گرفته شود',
			'sharje' => 'شارژ',
			'income' => 'درآمد',
			'unity' => 'واحد',
			'unity_status' => 'وضعیت واحد',
			'payment_code' => 'نحوه پرداخت',
			'transaction_num' => 'شماره برگ تراکنش',
			'date_cheque' => 'تاريخ چک',
			'bank_code' => 'بانک يا موسسه',
			'create_date' => 'تاریخ',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost_type_code',$this->cost_type_code);
		$criteria->compare('amount_sharje',$this->amount_sharje);
		$criteria->compare('amount_income',$this->amount_income);
		$criteria->compare('amount_unity',$this->amount_unity);
		$criteria->compare('sharje',$this->sharje);
		$criteria->compare('income',$this->income);
		$criteria->compare('unity',$this->unity);
		$criteria->compare('unity_status',$this->unity_status);
		$criteria->compare('payment_code',$this->payment_code);
		$criteria->compare('transaction_num',$this->transaction_num,true);
		$criteria->compare('date_cheque',$this->date_cheque,true);
		$criteria->compare('bank_code',$this->bank_code);
		$criteria->compare('create_date',$this->create_date,true);
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
	 * @return Cost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
