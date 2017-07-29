<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Notify;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class MessageController extends FrontendController
{
	public function actionCompose()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('message/compose'));
        }
        $this->canUser();

        $compose = new Notify;
        $model = new Notify;
        if ($compose->load(Yii::$app->request->post()))
        {
            $compose->receive_id = Notify::ADMIN_ID;
            $last_ms = Notify::find()->orderBy(['created_at' => SORT_DESC])->one();
            if (empty($last_ms->id)) {
                 $compose->all_id = 0;
            }else
            {
                $compose->all_id = $last_ms->id;
            }
            //Upload Image
            $imageName = preg_replace('/\s+/', '', $compose->title);
            $compose->file = UploadedFile::getInstance($compose,'file');      
            $save_folder = str_replace("frontend","backend",$_SERVER['DOCUMENT_ROOT'])."/uploads/message/";
            if ($compose->file) {
                $compose->file->saveAs($save_folder.$imageName.$compose->all_id.'.'.$compose->file->extension);                            
                $compose->attach_file = 'uploads/message/'.$imageName.$compose->all_id.'.'.$compose->file->extension;
            }
            //Upload Image
            $compose->user_id = Yii::$app->user->identity->id;
            $compose->title = $compose->title;
            $compose->content = $compose->content;
            $compose->created_at = time();
            $compose->updated_at = time();
            $compose->publish = Notify::PUBLISH_NOACTIVE;
            $compose->status = Notify::STATUS_ADMIN;
            if ($compose->save()) {
                Yii::$app->session->setFlash('success', 'Message sent successfully !');
                return $this->redirect(['sent',
                    'model' => $model,
                ]);
            }                           
            
        } else {
            return $this->render('compose', [
                'compose' => $compose,
            ]);
        }
    }

    // public function actionInbox()
    // {
    //     $model = Notify::find()->where(['receive_id' => (string) Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->limit(4)->all();
    //     return $this->render('inbox',[
    //         'model' => $model,
    //     ]);        
    // }

    public function actionInbox()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('message/inbox'));
        }
        $this->canUser();

        $query = Notify::find()->where(['receive_id' => Yii::$app->user->identity->id])->groupBy(['all_id', 'user_id'])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $model = new Notify();
        
        return $this->render('inbox', [
                'dataProvider' => $dataProvider,
                'model' => $model
        ]);
    }

    public function actionSent()
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('message/sent'));
        }
        $this->canUser();
        // $model = Notify::find()->where(['user_id' => Yii::$app->user->identity->id])->groupBy(['all_id', 'receive_id'])->orderBy(['created_at' => SORT_DESC])->all();
        // $user = User::find()->all();
        // return $this->render('sent',[
        //     'model' => $model,
        //     'user' => $user,
        // ]);

        $query = Notify::find()->where(['user_id' => Yii::$app->user->identity->id])->groupBy(['all_id', 'receive_id'])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        return $this->render('sent', [
                'dataProvider' => $dataProvider,
             
        ]);


    }
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest){            
            return $this->redirect('/login?redirect=' . Yii::$app->convert->redirect('message/view/'.$id));
        }
        $this->canUser();

        $model = Notify::findOne($id);        
        $model->publish = Notify::PUBLISH_ACTIVE;
        $model->save();
        $repply = new Notify;
        $ms = Notify::find()->where(['all_id'=> $model->all_id])->orderBy(['created_at' => SORT_ASC])->all();
        if ($repply->load(Yii::$app->request->post()))
        {
            $repply->user_id = Yii::$app->user->identity->id;
            $repply->receive_id = Notify::ADMIN_ID;
            $repply->title = $model->title;
            $repply->content = $repply->content;

            $repply->all_id = $model->all_id;

            
                $imageName = preg_replace('/\s+/', '', $model->title);

                $model->file = UploadedFile::getInstance($model,'file');
                $save_folder = str_replace("frontend","backend",$_SERVER['DOCUMENT_ROOT'])."/uploads/message/";
            if ($model->file) {
                $model->file->saveAs($save_folder.$imageName.$repply->all_id.'.'.$model->file->extension);
            
                $repply->attach_file = 'uploads/message/'.$imageName.$repply->all_id.'.'.$model->file->extension;
            }
            $repply->created_at = time();
            $repply->updated_at = time();
            $repply->publish = Notify::PUBLISH_NOACTIVE;
            $repply->status = Notify::STATUS_ADMIN;
            if($repply->save()){                
                Yii::$app->session->setFlash('success', 'Message sent successfully !');
                return $this->redirect(['view', 'id' => $id]);
            }

        }else
        return $this->render('view',[
            'model' => $model,
            'repply' => $repply,
            'ms'    => $ms,
        ]);
            
    }
    public function actionDeletes($id)
    {
        
        
            $this->findModel($id)->delete();
        
        return $this->redirect(['inbox', 'id' => $id]);
    }
    public function actionDelete($id)
    {
        
        
            $this->findModel($id)->delete();
        
        return $this->redirect(['sent', 'id' => $id]);
    }

    protected function findModel($id) {
        if (($model = Notify::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
?>