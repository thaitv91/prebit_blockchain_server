<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\web\IdentityInterface;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use common\models\ShTransfer;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\models\Converted;
use common\models\TokenRequest;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property float $total_withdraw
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;

    const PUBLISH_NOACTIVE = 1;
    const PUBLISH_ACTIVE = 2;

    const SHSTATUS_NOACTIVE = 1;
    const SHSTATUS_ACTIVE = 2;

    const ORDERBY_DOWNLINE_DESC = 1;
    const ORDERBY_DOWNLINE_ASC = 2;

    const BLOCK_NOACTIVE = 1;
    const BLOCK_ACTIVE = 2;

    const MALE = 1;
    const FEMALE = 2;

    const BRONZE    = 1;
    const SILVER    = 2;
    const GOLD      = 3;
    const PLATINUM  = 4;
    const DIAMOND   = 5;
    const MASTER    = 6;
    const GRANDMASTER = 7;
    const LEGENDARY = 8;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'fullname','password_hash', 'phone', 'country_id', 'bank_name', 'bank_cn', 'bank_id', 'bank_user_fullname'], 'required'],
            [['downline', 'shstatus', 'block', 'timeblock', 'sex', 'passport_id'], 'integer'],
            //[['id', 'sex', 'birthday', 'phone', 'country_id', 'state_id', 'city_id', 'level', 'level_updated_at', 'charity', 'charity_updated_at', 'wallet', 'manager_bonus', 'referral_bonus', 'token', 'referral_user_id', 'status', 'publish', 'created_at', 'updated_at'], 'integer'],
            //[['address', 'state_id', 'city_id', 'birthday', 'country_id'], 'string'],
            [['address', 'state_id', 'city_id', 'postcode', 'birthday', 'phone'], 'string'],
            //[['username', 'birthday', 'password_hash', 'auth_key', 'email', 'address', 'avatar', 'passport', 'identification', 'selfie'], 'string'],
            //[['fullname', 'slug_name', 'postcode', 'language'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'fullname' => 'Fullname',
            'slug_name' => 'Slug Name',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'phone' => 'Phone',
            'country_id' => 'Country ID',
            'state_id' => 'State ID',
            'city_id' => 'City ID',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'avatar' => 'Avatar',
            'description' => 'Description',
            'level' => 'Level',
            'level_updated_at' => 'Level Updated At',
            'charity' => 'Charity',
            'charity_updated_at' => 'Charity Updated At',
            'wallet' => 'Wallet',
            'manager_bonus' => 'Manager Bonus',
            'referral_bonus' => 'Referral Bonus',
            'token' => 'Token',
            'ticket' => 'Ticket',
            'referral_user_id' => 'Referral User ID',
            'language' => 'Language',
            'downline' => 'Downline',
            'shstatus' => 'Sh status',
            'status' => 'Status',
            'publish' => 'Publish',
            'passport' => 'Passport',
            'passport_id' => 'Passport Number',
            'identification' => 'Identification',
            'selfie' => 'Selfie',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'total_withdraw' => 'Total Withdraw',
            'has_withdrawn'  => 'Has Withdrawn',
            'bank_name' => 'Bank Name',
            'bank_cn' => 'Bank Branch',
            'bank_id' => 'Bank ID',
            'bank_user_fullname' => 'Bank User Fullname'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function getStatefromcountry($id){
        return States::find()->where(['country_id'=>$id])->all();
    }

    public static function getCitiesfromstate($id){
        return Cities::find()->where(['state_id'=>$id])->all();
    }

    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    public function getState()
    {
        return $this->hasOne(States::className(), ['id' => 'state_id']);
    }

    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
	
    public function getListCity()
    {
        $city = Cities::find()->all();
        foreach ($city as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }
	
    public function getListState()
    {
        $state = States::find()->all();
        foreach ($state as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }
	
    public function getListCountry()
    {
        $countries = Countries::find()->where(['publish'=>Countries::PUBLISH_ACTIVE])->orderBy(['name'=>SORT_ASC])->all();
        $data = array();
        foreach ($countries as $key => $value) {
            $data[$value['id']] = $value['name'];
        }
        return $data;
    }

    public function checkblockuser(){
        //get standby time block
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $standbyforblock = Converted::find()->where(['object'=>'standbyforblock'])->one();
        $users = User::find()->where(['status'=>User::STATUS_ACTIVE, 'block'=>User::BLOCK_NOACTIVE])->orderBy(['created_at'=>SORT_DESC])->all();
        foreach ($users as $key => $user) {
            $sql_sh = 'SELECT * FROM `sh_transfer` WHERE created_at >= ( '.time().' - ( '.$user->timeblock.' - created_at ) - ('.$standbyforblock->value.' * 60) )';
            $sendhelp = ShTransfer::findBySql($sql_sh)->all();
            
            $sql_gh = 'SELECT * FROM `gh_transfer` WHERE created_at >= ( '.time().' - ( '.$user->timeblock.' - created_at ) - ('.$standbyforblock->value.' * 60) )';
            $gethelp  = GhTransfer::findBySql($sql_gh)->all();

            $sql_token = 'SELECT * FROM `token_request` WHERE created_at >= ( '.time().' - ( '.$user->timeblock.' - created_at ) - ('.$standbyforblock->value.' * 60) )';
            $tokenrequset = TokenRequest::findBySql($sql_token)->all();

            $useritem = User::findOne($user->id);

            if(empty($sendhelp) && empty($gethelp) && empty($tokenrequset) && ( $standbyforblock->value * 60 > $useritem->timeblock)){
                $userblock = User::findOne($user->id);
                $userblock->block = User::BLOCK_ACTIVE;
                $userblock->timeblock = time();
                $userblock->save();

                $blocklist = new BlockList;
                $blocklist->user_id = $user->id;
                $blocklist->status = BlockList::BLOCK_ACTIVE;
                $blocklist->updated_at = time();
                $blocklist->created_at =time();
                $blocklist->save();

                //send mail register
                $mailin->
                    addTo($userblock->email, $userblock->username)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                    setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                    setSubject('Your account has blocked')->
                    setText('Hello '.$userblock->username.'!')->
                    setHtml('<p>Your account has been blocked for not having any activities for more than '.$standbyforblock->value.' hour<p>');
                $res = $mailin->send();
            }
        }
    }
    
    public static function findManagerparent($id = NULL, &$data = []){
        $user = User::findOne($id);
        if(!empty($user)){
            $data[] = $user->referral_user_id;
            $user->findManagerparent($user->referral_user_id, $data);
        }
        return $data;
    }

    public static function getDownlinetreemember($id, &$data = [])
    {
        $user = User::find()->where(['referral_user_id'=>$id])->all();
        $model = new User;
        //$data = array();
        foreach ($user as $key => $userid) {
            $data[][$id] = $userid->id;
            $model->getDownlinetreemember($userid->id, $data);
        }
        return $data;
    }

    public static function findDownlinetree($id){
        return User::find()->where(['referral_user_id' => $id])->orderBy(['created_at'=>SORT_DESC])->all();
    }

    public function updateLevel($id){
        $user = User::findOne($id);
        if(!empty($user)){
            $level = LevelSetting::find()->where(['level'=> $user->level + 1])->one();
            $total_sh = ShTransfer::find()->where(['user_id'=>$id])->sum('amount');

            //condition 1
            $total_member = User::find()->where(['referral_user_id'=>$id, 'status'=>User::STATUS_ACTIVE])->andWhere(['>=','level', $level->child_level])->count(); 

            //condition 2
            $total_member2 = User::find()->where(['referral_user_id'=>$id, 'status'=>User::STATUS_ACTIVE])->andWhere(['>=','level', $level->child_level_2])->count(); 

            if( (($total_sh >=  $level->amount) && ($total_member >= $level->child)) ||  (($total_sh >=  $level->amount) && ($total_member2 >= $level->child_2)) ){
                $user->level = $level->level;
                if( $user->save() ){
                    $user->updateLevel($user->referral_user_id);
                }
            } 
        }
        
    } 

    public static function getTotalSh($id){
        return ShTransfer::find()->where(['user_id' => $id])->sum('amount');
    }
    public static function getTotalShthismonth($id){
        $fday_thismonth = strtotime(date("Y-n-j", strtotime("first day of this month")));
        $lday_thismonth = strtotime(date("Y-n-j", strtotime("last day of this month")));
        return ShTransfer::find()->where(['user_id' => $id])->andWhere(['>=','created_at', $fday_thismonth])->andWhere(['<=','created_at', $lday_thismonth])->sum('amount');
    }
    public static function getUserSh($id)
    {
        return ShTransfer::find()->where(['user_id'=>$id])->sum('amount');
    }
    public static function getUserGh($id)
    {
        return GhTransfer::find()->where(['user_id'=> $id])->sum('amount');
    }
    //GET USER DONATE
    public static function getUserDn($id)
    {
        return CharityDonors::find()->where(['user_id'=>$id])->sum('amount');
    }

    public static function getUserReferral($id)
    {

        $user = User::find()->where(['referral_user_id'=>$id])->andWhere(['status' => User::STATUS_ACTIVE ])->all();
        $data = array();
        foreach ($user as $key => $userid) {
            $data[$userid->id] = $userid->id;
        }
        return $data;
    }

    public static function getUserReferralMonth ($id, $cv_dateto, $cv_datefrom){
        $user = User::find()->where(['referral_user_id'=>$id])->andWhere(['status' => User::STATUS_ACTIVE ])->andWhere(['>=', 'created_at', $cv_dateto])->andWhere(['<=', 'created_at', $cv_datefrom])->all();
        $data = array();
        foreach ($user as $key => $userid) {
            $data[$userid->id] = $userid->id;
        }
        return $data;
    }

    

    //GET ACTIVE MEMBER BY REFERRAL
    public static function getUserActive($id)
    {
        $user = User::find()->where(['referral_user_id'=>$id, 'publish' => User::PUBLISH_ACTIVE])->all();
        $data = array();
        foreach ($user as $key => $userid) {
            $shtransfer = ShTransfer::find()->where(['user_id'=> $userid->id])->count();
            if ($shtransfer > 0) {
                $data[$userid->id] = $userid->id;
            }
        }
        return $data;
    }

    public static function getUserParrent($id)
    {
        return User::findOne($id);
    }

    public static function getAddressbitcoin($username){
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        return $client->getAddress($username);
    }

    public function getTotaldownlinef1($id){
        return User::find()->where(['referral_user_id' => $id])->all();
    }

    public function getblock($id){
        return BlockList::find()->where(['user_id'=>$id])->orderBy(['created_at'=>SORT_DESC])->one();
    }

    public static function getAuthkeyUser($email) {
        $model = User::find()->where(['email' => $email])->one();
        if (!empty($model)) {
            return $model->auth_key;
        } else {
            return Yii::$app->security->generateRandomString();
        }
    }

    public static function getSumamountshdate($userid, $dateto, $datefrom){
        return ShTransfer::find()->where(['user_id'=>$userid])->andWhere(['>=', 'created_at', $dateto])->andWhere(['<=', 'created_at', $datefrom])->sum('amount');
    }

    public static function sendmailupload($id){
        $model = User::findOne($id);
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);
        $mailtemplate = new MailTemplate;

        if( empty($model->passport) && empty($model->identification) && empty($model->selfie)){
            $contentmail = '<p style="margin:0"><b>'.$model->username.'</b> uploaded verify file.</p>';
            $mailin->
                addTo(Yii::$app->params['verifyEmail'])-> 
                setFrom(Yii::$app->params['verifyEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['verifyEmail'],'PreBit')->
                setSubject(''.$model->username.' uploaded verify file')->
                setText(''.$model->username.' uploaded verify file')->
                setHtml($mailtemplate->loadMailtemplate($model->fullname, $contentmail));
            $res = $mailin->send();
        }
    }
}

