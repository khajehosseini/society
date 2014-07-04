<?php

/**
 * This is the model class for table "{{income}}".
 *
 * The followings are the available columns in table '{{income}}':
 * @property integer $id
 * @property integer $block_code
 * @property string $description
 * @property integer $amount
 * @property integer $payment_code
 * @property string $transaction_num
 * @property string $date_cheque
 * @property integer $bank_code
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Block $blockCode
 * @property Payment $paymentCode
 * @property Bank $bankCode
 */
class Income extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{income}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, payment_code ', 'required'),
			array('block_code, amount, payment_code, bank_code', 'numerical', 'integerOnly'=>true),
			array('transaction_num', 'length', 'max'=>255),
			array('description, date_cheque,create_date,block_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, block_code, description, amount, payment_code, transaction_num, date_cheque, bank_code, create_date', 'safe', 'on'=>'search'),
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
			'paymentCode' => array(self::BELONGS_TO, 'Payment', 'payment_code'),
			'bankCode' => array(self::BELONGS_TO, 'Bank', 'bank_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'block_code' => 'بلوک',
			'description' => 'شرح',
			'amount' => 'مبلغ',
			'payment_code' => 'طریقه پرداخت',
			'transaction_num' => 'شماره برگه تراکنش',
			'date_cheque' => 'تاریخ چک',
			'bank_code' => 'بانک یا موسسه',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('block_code',$this->block_code);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_code',$this->payment_code);
		$criteria->compare('transaction_num',$this->transaction_num,true);
		$criteria->compare('date_cheque',$this->date_cheque,true);
		$criteria->compare('bank_code',$this->bank_code);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Income the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
