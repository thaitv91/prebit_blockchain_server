<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Notify;
use yii\web\UploadedFile;
use common\extensions\Mailin;
use common\extensions\MailTemplate;
/**
 * Site controller
 */
class MessageController extends BackendController
{
    public function actionCompose()
    {   
        $model = new Notify;
        if ($model->load(Yii::$app->request->post()))
        {
            $receive_id = $model->receive_id;

            foreach ($receive_id as $value) {
                $notify = new Notify;
                $notify->receive_id = $value;
                $last_ms = Notify::find()->orderBy(['created_at' => SORT_DESC])->one();             
                if (empty($last_ms->id)) {
                     $notify->all_id = 0;
                }else
                {
                    $notify->all_id = $last_ms->id;
                }
                $imageName = preg_replace('/\s+/', '', $model->title);
                $model->file = UploadedFile::getInstance($model,'file');      
                $save_folder = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/uploads/message/";
                if ($model->file) {
                    $model->file->saveAs($save_folder.$imageName.$notify->all_id.'.'.$model->file->extension);                            
                    $notify->attach_file = 'uploads/message/'.$imageName.$notify->all_id.'.'.$model->file->extension;
                }
                $notify->title = $model->title;
                $notify->content = $model->content;
                $notify->created_at = time();
                $notify->updated_at = time();
                $notify->publish = Notify::PUBLISH_NOACTIVE;
                $notify->status = Notify::STATUS_ADMIN;
                $notify->save();                
                Yii::$app->session->setFlash('success', 'Message sent successfully !');
            }
            return $this->redirect(['compose', 'id' => $model->id]);
        } else {
            return $this->render('compose', [
                'model' => $model,
            ]);
        }
    }


    public function actionNotification()
    {
        $model = new Notify;
        if ($model->load(Yii::$app->request->post()))
        {
            $mailin = new Mailin(Yii::$app->params['user_mailin'], Yii::$app->params['pasw_mailin']); 
            $mailtemplate = new MailTemplate;
            $users = User::find()->all();
            $contentmail = $model->content;
            foreach ($users as $user) {
                
                //send mail register
                $mailin->
                    addTo($user->email, $user->username)-> 
                    setFrom(Yii::$app->params['supportEmail'], 'PreBit')->
                    setReplyTo(Yii::$app->params['supportEmail'],'PreBit')->
                    setSubject('Notification From Admin')->
                    setText('Hello '.$user->fullname.'!')->
                    setHtml($mailtemplate->loadMailtemplate($user->fullname, $contentmail));
                //$res = $mailin->send();
                    var_dump($mailin);
                Yii::$app->session->setFlash('success', 'Message sent successfully !');
            }
            return $this->redirect(['notification', 'id' => $model->id]);
        } else {
            return $this->render('notification', [
                'model' => $model,
            ]);
        }
    }

    public function actionInbox()
    {
        
        $query = Notify::find()->where(['receive_id' => Notify::ADMIN_ID])->groupBy(['all_id', 'receive_id'])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);        
        $model = Notify::find()->all();
        $countmessage = Notify::find()->where(['publish' => Notify::PUBLISH_NOACTIVE, 'receive_id'=>Notify::ADMIN_ID])->count();
        return $this->render('inbox', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'countmessage' => $countmessage,
        ]);
    }

    public function actionSent()
    {
        $query = Notify::find()->where(['user_id' => Notify::ADMIN_ID])->groupBy(['all_id', 'user_id'])->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $model = new Notify();
        $countmessage = Notify::find()->where(['publish' => Notify::PUBLISH_NOACTIVE, 'receive_id'=>Notify::ADMIN_ID])->count();
        return $this->render('inbox', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'countmessage' => $countmessage,
        ]);
    }
    public function actionView($id)
    {        
        $model = Notify::findOne($id);
        $model->publish = Notify::PUBLISH_ACTIVE;
        $model->save();
        

        $repply = new Notify;
        $ms = Notify::find()->where(['all_id'=> $model->all_id])->orderBy(['created_at' => SORT_ASC])->all();
        if ($repply->load(Yii::$app->request->post()))
        {

            $repply->user_id = Notify::ADMIN_ID;
            $repply->receive_id = $model->user_id;
            $repply->title = $model->title;
            $repply->content = $repply->content;

            $repply->all_id = $model->all_id;                
            
            $last_ms = Notify::find()->where(['id' => Notify::find()->max('id')])->one();

            $imageName = preg_replace('/\s+/', '', $repply->title);

            $model->file = UploadedFile::getInstance($model,'file');
            $save_folder = str_replace("backend","frontend",$_SERVER['DOCUMENT_ROOT'])."/uploads/message/";
            if ($model->file) {
                 $model->file->saveAs($save_folder.$imageName.$last_ms->id.'.'.$model->file->extension);
            
           
            $repply->attach_file = 'uploads/message/'.$imageName.$last_ms->id.'.'.$model->file->extension;           
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
    public function actionDelete($id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $value) {
            $this->findModel($value)->delete();
        }
        return $this->redirect(['inbox', 'id' => $id]);
    }
    protected function findModel($id) {
        if (($model = Notify::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }
}
?>