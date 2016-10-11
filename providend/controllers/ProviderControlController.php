<?php

namespace providend\controllers;

use Yii;
use providend\models\ProviderControl;
use providend\models\ProviderControlSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProviderControllController implements the CRUD actions for ProviderControl model.
 */
class ProviderControlController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProviderControl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'dash';
        
        $searchModel = new ProviderControlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all AdminControl models.
     * @return mixed
     */
    public function actionDashboard()
    {
                $this->layout = 'dash';

                $searchModel = new ProviderControlSearch();
                $dataProvider = $searchModel->search(['ProviderControlSearch'=>['prov_id'=>Yii::$app->user->id]]);
                
                //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->redirect('dashboard', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $this->findModel(Yii::$app->user->id),
                    ]);
    }




    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionLogin()
    {
        //$this->layout = 'dash';

        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('dashboard', [
                'model' => $this->findModel(Yii::$app->user->id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Displays a single ProviderControl model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the ProviderControl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProviderControl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProviderControl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
