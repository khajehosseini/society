<?php

/**
 * This is the model class for table "{{charge}}".
 *
 * The followings are the available columns in table '{{charge}}':
 * @property integer $id
 * @property integer $unity_code
 * @property integer $user_code
 * @property integer $month_code
 * @property integer $year_code
 * @property integer $payment_code
 * @property string $amount
 * @property string $transaction_num
 * @property string $date_cheque
 * @property integer $bank_code
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Users $userCode
 * @property Payment $paymentCode
 * @property Bank $bankCode
 * @property Unity $unityCode
 * @property Month $monthCode
 * @property Year $yearCode
 */
class Charge extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{charge}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unity_code, user_code, month_code, year_code, payment_code, amount', 'required'),
			array('unity_code, user_code, month_code, year_code, payment_code, bank_code', 'numerical', 'integerOnly'=>true),
			array('amount, transaction_num', 'length', 'max'=>255),
			array('date_cheque	,create_date,	user_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, unity_code, user_code, month_code, year_code, payment_code, amount, transaction_num, date_cheque, bank_code, create_date', 'safe', 'on'=>'search'),
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
			'userCode' => array(self::BELONGS_TO, 'User', 'user_code'),
			'paymentCode' => array(self::BELONGS_TO, 'Payment', 'payment_code'),
			'bankCode' => array(self::BELONGS_TO, 'Bank', 'bank_code'),
			'unityCode' => array(self::BELONGS_TO, 'Unity', 'unity_code'),
			'monthCode' => array(self::BELONGS_TO, 'Month', 'month_code'),
			'yearCode' => array(self::BELONGS_TO, 'Year', 'year_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',

			'unity_code' => 'نام واحد',
			'user_code' => 'نام کاربري',
			'month_code' => 'ماه',
			'year_code' => 'سال',
			'payment_code' => 'نحوه پرداخت',
			'amount' => 'ميزان',
			'transaction_num' => 'شماره تراکنش',
			'date_cheque' => 'تاريخ چک',
			'bank_code' => 'بانک',
			'create_date' => 'تاريخ ايجاد',
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
	public function search($block_id	=	''	,	$unity_id	=	''	,	$user_id	=	'')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with	=	'unityCode';	
		$criteria->compare('id',$this->id);
		if($unity_id	!=	''	&&	is_numeric($unity_id))
			$criteria->compare('unity_code',$unity_id);
		else	
			$criteria->compare('unity_code',$this->unity_code);
			
			
		if($user_id	!=	''	&&	is_numeric($user_id))
			$criteria->compare('user_code',$user_id);
		else	
			$criteria->compare('user_code',$this->user_code);
	
	
		$criteria->compare('month_code',$this->month_code);
		$criteria->compare('year_code',$this->year_code);
		$criteria->compare('payment_code',$this->payment_code);
		$criteria->compare('amount',$this->amount,true);
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
	 * @return Charge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
