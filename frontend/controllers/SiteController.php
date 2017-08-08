<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use common\models\User;
use frontend\models\RegisterForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ChangePassword;
use common\extensions\jsonRPCClient;
use common\extensions\Client;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
use common\models\Newsmanagement;
use common\models\CharityProgram;
use common\models\CharityDonors;
use common\models\Converted;
use common\models\BlockList;
use common\models\BitcoinWallet;
use common\models\ShTransfer;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    public $notfoundUrl = '/site/404';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'error', 'forgetpassword', 'changepassword'],
                'rules' => [
                    [
                        'actions' => ['login', 'request-password-reset', 'error', 'register', 'changepassword', 'confirmregister', 'unblock', '404'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','checkcode'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	public function beforeAction($action) {
			$this->enableCsrfValidation = false;
			return parent::beforeAction($action);
	}

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('site/index'));
        }
        $this->canUser();
        define("IN_WALLET", true);
        
        $user = User::findOne(Yii::$app->user->identity->id);

        //test mail 
        // $mailtemplate = new MailTemplate;
        // $mailin = new Mailin('support@ebank.tv', 'QpRfvH4FGSN5tYKb');
        // $mailin->
        // addTo('thachbond@gmail.com', 'Michael Ingersoll')->
        // setFrom('support@ebank.tv', 'Michael Ingersoll')->
        // setReplyTo('support@ebank.tv','Michael Ingersoll')->
        // setSubject('Enter the subject here')->
        // setText('Hello')->
        // setHtml('<strong>Hello</strong>');
        // $res = $mailin->send();
        // var_dump($res); exit;




        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $address_btc = $client->getAddressList($user->username);
        $balance_btc = $client->getBalance($user->username);
        $model = Newsmanagement::find()->where(['publish' => Newsmanagement::PUBLISH_ACTIVE])->orderBy(['created_at' => SORT_DESC])->all();
        $notification = Newsmanagement::find()->where(['id' => 13])->orderBy(['created_at' => SORT_DESC])->one();
        $program = CharityProgram::find()->where(['publish' => CharityProgram::PUBLISH_ACTIVE])->orderBy(['endday' => SORT_DESC])->limit(1)->all();
        //get all sh transfer active
        $active_sh = ShTransfer::find()->where(['user_id'=>$user->id, 'publish'=>ShTransfer::PUBLISH_ACTIVE])->andWhere(['<','status', ShTransfer::STATUS_COMPLETED])->orderBy(['created_at'=>SORT_DESC])->limit(2)->all();
        return $this->render('index', [
            'user'=>$user,
            'address_btc' => $address_btc,
            'balance_btc' => $balance_btc,
            'model'       => $model,
            'notification' => $notification["content"],
            'program'     => $program,
            'active_sh'   => $active_sh,
            ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';
		$session = Yii::$app->session; 
		
		
         if (!Yii::$app->user->isGuest && $session['is_auth_tw'] = '0') {
            return $this->goHome();
        } 
		$session['is_auth_tw'] = '0';
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $userDetails= User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
           
			$session['google_code'] = $_POST['google_secret_code'];
			$session['is_auth_tw'] = '0';
            $secret = $userDetails['google_auth_code'];
            if(empty($secret)){
                $userDetails->google_auth_code = $_POST['google_secret_code'];
                 $userDetails->save(false);

            }else{
                if($userDetails['fa_setting']==1){
					$session['is_auth_tw'] = '1';
                    return $this->render('device_confirmations',['email'=>$userDetails['email'],'secret'=>$secret]);
                }else{
                    if (!empty($_GET['redirect'])) {
                return $this->redirect(Yii::$app->convert->url($_GET['redirect']));
            } else {
                return $this->goBack();
            }
                }
            }

            if (!empty($_GET['redirect'])) {
                return $this->redirect(Yii::$app->convert->url($_GET['redirect']));
            } else {
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionCheckcode(){
		$this->layout='';
		$userDetails = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
		$code = $_POST['code'];
		$secret_code =  $userDetails->google_auth_code;
		$session = Yii::$app->session; 
		$session['is_auth_tw'] = '0';
		return $this->render('check_code',['code'=>$code,'secret'=>$secret_code]);
       
    }

    public function actionUnblock(){
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('site/unblock'));
        }
        $this->layout = 'unblock';
        define("IN_WALLET", true);
        //get account bitcoin wallet max amount
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $BitcoinWallet = new BitcoinWallet;
        $blockList = new BlockList;
        //get account penalty wallet of admin
        $account_wallettoken = $BitcoinWallet->findBitcoinaddress(BitcoinWallet::TYPE_Penaltywallet, 'min');
        //get fine amounts for unblock
        $fineamount = Converted::find()->where(['object'=>'fineamount'])->one();
        //get balance bitcoin wallet of user
        $btc = $client->getBalance(Yii::$app->user->identity->username);
        $user = User::findOne(Yii::$app->user->identity->id);
        $blocklistuser = BlockList::find()->where(['user_id'=>$user->id, 'status'=>BlockList::BLOCK_ACTIVE])->all();


        if ($blockList->load(Yii::$app->request->post())){
            if($btc < $fineamount->value){
                Yii::$app->session->setFlash('error', 'Your PreBit wallet balance is not enough!');
                return $this->render('unblock', [
                    'blockList' => $blockList,
                    'account_wallettoken' => $account_wallettoken,
                    'fineamount' => $fineamount->value,
                ]);
            }else{
                //send bitcoin to penalty wallet
                $sendbitcoin = $client->withdraw($user->username, $account_wallettoken, $btc);
                if($sendbitcoin){

                    //update block history
                    $blocklist = BlockList::find()->where(['user_id'=>$user->id, 'status'=>BlockList::BLOCK_ACTIVE])->all();
                    foreach ($blocklist as $key => $block) {
                        $blockchange = BlockList::findOne($block->id);
                        $blockchange->status = BlockList::BLOCK_NOACTIVE;
                        $blockchange->amount = $btc;
                        $blockchange->updated_at = time();
                        $blockchange->save();
                    }

                    Yii::$app->getSession()->setFlash('success', 'Your unblock request has been sent!');
                }else{
                    Yii::$app->getSession()->setFlash('error', 'This action failed!');
                }
                return $this->redirect(['site/unblock']);
            }
        }
        
        return $this->render('unblock', [
            'blockList' => $blockList,
            'account_wallettoken' => $account_wallettoken,
            'fineamount' => $fineamount->value,
            'blocklistuser' => $blocklistuser,
        ]);
    }


    public function actionLogout()
    {
		$session = Yii::$app->session; 
		
		$session['is_auth_tw'] = '0';
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            var_dump($user); exit;
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionRegister(){
        define("IN_WALLET", true);
        $client = new Client(Yii::$app->params['rpc_host'], Yii::$app->params['rpc_port'], Yii::$app->params['rpc_user'], Yii::$app->params['rpc_pass']);
        $this->layout = 'login';
        $model = new RegisterForm();
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;
        $tokenregister = Converted::find()->where(['object'=>'tokenregister'])->one();     
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['g-recaptcha-response'])){
                $captcha=$_POST['g-recaptcha-response'];
                if(!$captcha){
                    \Yii::$app->getSession()->setFlash('error', '<p class="text-red">Please select Google reCAPTCHA.</p>');
                    return $this->render('register', [
                        'model' => $model
                    ]);
                }
            }
            if ($model->validate()) {
                $user = new User();
                if(!empty($model->referral_id)){
                    $referral = User::find()->where(['username'=>$model->referral_id])->one();
                    $user->referral_user_id = $referral->id;
                }
                $user->username = $model->username;
                $user->email = $model->email;
                $user->fullname = $model->fullname;
                $user->slug_name = str_replace("-", " ", Yii::$app->convert->string($model->fullname));
                $user->phone = $model->phone;
                $user->country_id = $model->country;
                $user->token = $tokenregister->value;
                $user->created_at = $user->updated_at = $user->timeblock = time();
                $user->status = User::STATUS_NOACTIVE;
                $user->publish = User::PUBLISH_NOACTIVE;
                $user->setPassword($model->password);
                $user->generateAuthKey(); 
                if ($user->save()) {

                    // get manager parent 
                    if(!empty($user->referral_user_id)){
                        $manager_parent = $user->findManagerparent($user->id);
                        foreach ($manager_parent as $key => $userid) {
                            $user_manager = User::findOne($userid);
                            if(!empty($user_manager)){
                                $user_manager->downline = $user_manager->downline + 1;
                                $user_manager->save();
                            }
                        }
                    }

                    //send mail register
                    $contentmail = '<p style="margin:0">Confirm your email address to complete your PreBit account. It’s easy - just click on the button below.</p><p></p><p><a style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;" href="'.Yii::$app->params['url_file'].'site/confirmregister?email=' . $user->email . '&auth_key=' . $user->auth_key.'">Confirm my email address →</a><p><br><p>For your reference, your username is <b>'.$user->username.'</b> for logging in.</p>';
                    $mailin->
                        addTo($user->email, $user->username)-> 
                        setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                        setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                        setSubject('Confirm your PreBit account')->
                        setText('Hello '.$user->fullname.'!')->
                        setHtml($mailtemplate->loadMailtemplate($user->fullname, $contentmail));
                    $res = $mailin->send();

                    // create bitcoin address
                    $client->getNewAddress($user->username);
                    return $this->render('confirmregister', [
                        'email' => $user->email,
                    ]);
                }
            }
        }

        return $this->render('register', [
                    'model' => $model
        ]);

    }




    public function actionConfirmregister()
    {
        if (!empty($_GET['email']))
        {
            $user = User::find()->where(['email' => $_GET['email'], 'publish' => User::PUBLISH_NOACTIVE, 'auth_key' => $_GET['auth_key']])->one();
            if (!empty($user))
            {
                if($user->status == User::STATUS_ACTIVE){
                    return $this->redirect(['site/login']);
                }

                $user->status = User::STATUS_ACTIVE;
                if ($user->save())
                {
                    if(!empty($user->referral_user_id)){
                        //******************************//
                        //***update level all member****//
                        //******************************//
                        $user->updateLevel($user->referral_user_id);
                    }
                    $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
                    $mailtemplate = new MailTemplate;
                    if (Yii::$app->getUser()->login($user))
                    {
                         //send mail register
                        $contentmail = 'Thanks for joining our global community.<p></p>

<p>Good Luck</p>';
                        $mailin->
                            addTo($user->email, $user->username)-> 
                            setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                            setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                            setSubject('Welcome to PreBit')->
                            setText('Hello '.$user->fullname.'!')->
                            setHtml($mailtemplate->loadMailtemplate($user->fullname, $contentmail));
                        $res = $mailin->send();


                        return $this->redirect(['index']);
                    }else{
                        var_dump('confirm false'); exit;
                    }
                }
            }
            else
            {
                throw new \yii\web\NotFoundHttpException('This account does not exist in the system.');
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException('This page does not exist in the system.');
        }
    }



    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']);  
        $mailtemplate = new MailTemplate;
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $authKey = $user->getAuthkeyUser($model->email);
            $username = User::find()->where(['email'=>$model->email])->one();

            //send mail register
            $contentmail = '<p style="margin:0">You told us you forgot your password. If you really did, click the link below to choose a new one:</p><p><a style="text-decoration:none;color: #FFF;background-color: #1fcf93;padding:10px 16px;font-weight:bold;margin-right:10px;text-align:center;cursor:pointer;display: inline-block;border-bottom:2px solid #1ab07d;font-weight:400;font-size:18px;" href="' . Yii::$app->params['url_file'] . 'site/changepassword?email=' . $model->email . '&auth_key=' . $authKey . '">Reset password →</a><p>';

            $mailin->
                addTo($model->email, $model->email)-> 
                setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                setSubject('Reset your PreBit password')->
                setText('Hello '.$model->email.'!')->
                setHtml($mailtemplate->loadMailtemplate($username->fullname, $contentmail));
            $res = $mailin->send();

            if($res){
                return $this->render('confirmpasswordreset');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionConfirmpasswordreset(){
        $this->layout = 'login';
        return $this->render('confirmpasswordreset');
    }


    public function actionChangepassword()
    {
        $this->layout = 'login';
        $model = new ChangePassword();
        
        if(!empty($_GET['email']) && !empty($_GET['auth_key'])){
            $user = User::find()->where(['email' => $_GET['email'], 'auth_key' => $_GET['auth_key'] ])->one();
            if(!empty($user)){
                if ($model->load(Yii::$app->request->post()))
                {
                    if ($model->validate())
                    {
                        $user->setPassword($model->password);
                        if ($user->save())
                        {
                            if (Yii::$app->getUser()->login($user))
                            {
                                return $this->redirect(['index']);
                            }else{
                                return $this->redirect(['404']);
                            }
                        }
                    } 
                } 
                return $this->render('changepassword', ['model' => $model]);
            } else {
                 return $this->redirect(['404']);
            }
        } else {
            return $this->redirect(['404']);
        }       
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function action404(){
        $this->layout = 'error404';
        return $this->render('error404');
    }

}
