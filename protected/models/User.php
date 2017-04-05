<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $pass
 * @property string $type
 * @property string $date_entered
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property File[] $files
 * @property Page[] $pages
 */
class User extends CActiveRecord
{
	public $passCompare; // Needed for registration!
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// Required fields when registering:
			array('username, name, email, pass', 'required', 'on'=>'insert'),
			// Username must be unique and less than 45 characters:
			array('email, username', 'unique'),
			array('username', 'length', 'max'=>45),
			array('name', 'length', 'max'=>40),
			// Email address must also be unique (see above), an email address
			// and less than 60 characters:
			array('email', 'email'),
			array('email', 'length', 'max'=>60),
			// Password must match a regular expression:
			array('pass', 'match', 'pattern'=>'/^[a-z0-9_-]{6,20}$/i'),
			// Password must match the comparison:
			//array('pass', 'compare', 'compareAttribute'=>'passCompare', 'on'=>'register'),
			// Set the type to "public" by default:
			array('type', 'default', 'value'=>'public'),
			// Type must also be one of three values:
			array('type', 'in', 'range'=>array('public','author','admin')),
			// Set the date_entered to NOW():
			array('date_entered', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'insert'),
			//array('date_updated', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, name, email, pass, type, date_entered', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'files' => array(self::HAS_MANY, 'File', 'user_id'),
			'pages' => array(self::HAS_MANY, 'Page', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'name' => 'Full Name',
			'email' => 'Email',
			'pass' => 'Password',
			'type' => 'Type',
			'date_entered' => 'Date Entered',
			'comparePass' => 'Password Confirmation'
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('date_entered',$this->date_entered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
