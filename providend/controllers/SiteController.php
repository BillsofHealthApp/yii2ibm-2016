<?php
namespace providend\controllers;

use Yii;
use providend\models\Providers;
use providend\models\ProvidersSearch;
use providend\models\ProviderControl;
use providend\models\ProviderControlSearch;

use common\models\ProvidersLoginForm;
use providend\models\PasswordResetRequestForm;
use providend\models\ResetPasswordForm;
use providend\models\SignupForm;

use providend\models\ContactForm;
use providend\models\FaqForm;
//use providend\models\DocSearch;
//use providend\models\FooterMenuSearch;
//use providend\models\SubmenuSearch;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    //[
                    //    'actions' => ['login', 'error'],
                    //    'allow' => true,
                    //],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
                //'level' => 1, // avaliable level are 1,2,3 :D
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'offset' => 2, // space between characters 
                'testLimit' => 1, // how many times should the same CAPTCHA be displayed 
                //'padding' => 10 // padding around the text  
            ],

            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    
    /**
    * This function will be triggered when user is successfuly authenticated using some oAuth client.
    *
    * @param yii\authclient\ClientInterface $client
    * @return boolean|yii\web\Response
    */
    public function oAuthSuccess($client) {
    // get user data from client
    $userAttributes = $client->getUserAttributes();

    // do some thing with user data. for example cubrid_connect_with_url(conn_url) $userAttributes['email']
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {


        if (isset($_POST['joinbutton'])) {  
                return $this->redirect(['site/signup',]);
            } 
        elseif (isset($_POST['loginbutton'])) {  
                return $this->redirect(['site/login',]);
            } 
        else {
            if (Yii::$app->user->isGuest) {
                return $this->render('index', []);
            }
            else {

                $this->layout = 'dash';

                $searchModel = new ProviderControlSearch();
                 //$dataProvider = $searchModel->search(['ProviderControlSearch'=>['visible'=>'1']]);
                $dataProvider = $searchModel->search(['ProviderControlSearch'=>['prov_id'=>Yii::$app->user->id]]);
                
                //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('/provider-control/dashboard', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $this->findModel(Yii::$app->user->id),
                    ]);
                //return $this->render('index', []);
               //return $this->render('/provider-control/dashboard', []);                
            }
        }    

    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new ProvidersLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

                $this->layout = 'dash';

                $searchModel = new ProviderControlSearch();
                $dataProvider = $searchModel->search(['ProviderControlSearch'=>['prov_id'=>Yii::$app->user->id]]);
            
                return $this->render('/provider-control/dashboard', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $this->findModel(Yii::$app->user->id),
                    ]);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
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
            if ($user = $model->signup()) {
                    $userb = new ProviderControl();
                    $userb->prov_id = $user->id;
                    $userb->save();
                if (Yii::$app->getUser()->login($user)) {

                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
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

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionPlogin()
    {
        $this->layout = 'dash';

        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {    
            return $this->redirect(['/provider-control/login']);
        } 
        else 
        {
            return $this->render('/provider-control/login', 
                [
                'model' => $model,
                ]);
        }
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionProfile()
    {
        $this->layout = 'dash';

        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {    
            return $this->redirect(['/provider-control/profile']);
        } 
        else 
        {
            return $this->render('/provider-control/profile', 
                [
                'model' => $model,
                ]);
        }
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionBusiness()
    {
        $this->layout = 'dash';

        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {    
            return $this->redirect(['/provider-control/business']);
        } 
        else 
        {
            return $this->render('/provider-control/business', 
                [
                'model' => $model,
                ]);
        }
    }







    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Providers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
