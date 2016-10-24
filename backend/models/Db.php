<?php
namespace backend\models;


use Yii;
use yii\base\Model;
use common\models\CardVoice;
use common\models\Page;
/**
 * Login form
 */
class Db extends Model
{
    public static function get_card_one($result){
        $result = Yii::$app->db->createCommand('SELECT *, card_voice.id as card_voice_id, page.id as page_id FROM card_voice JOIN category on card_voice.category_id=category.id join page on card_voice.id=page.card_id where  card_voice.id=:id order by card_voice.id limit 1')
        ->bindValue(':id', $result)
        ->queryOne();
        return $result;
    }

    public static function get_page_one($result){
        $result = Yii::$app->db->createCommand('SELECT * FROM page where id=:id limit 1')
            ->bindValue(':id', $result)
            ->queryOne();
        return $result;
    }

    public static function get_page_all($filter){

        $query = Page::find()
            ->orderBy('id');

        if (!empty($filter) and $filter==1){
            $query = Page::find()
                ->where(['=','status', Page::STATUS_ACTIVE])
                ->orderBy('id');
        }
        if (!empty($filter) and $filter==2){
            $query = Page::find()
                ->Where(['=','status', Page::STATUS_DEACTIVE])
                ->orderBy('id');
        }
        if (!empty($filter) and $filter==3 and !empty($filter_category)){
            $query = Page::find()
                ->where(['<>','status', $filter])
                ->orderBy('id');
        }

        return $query;
    }

    public static function get_card_all($filter,$filter_category){
        $query = CardVoice::find()
            ->select('card_voice.*,category.name')
            ->joinWith('category')
            ->orderBy('id');

        if (!empty($filter) and $filter==3 and !empty($filter_category)){
            $query = CardVoice::find()
            ->select('card_voice.*,category.name')
                ->joinWith('category')
                ->where(['<>','status', $filter])
                ->andWhere(['=','category_id', $filter_category])
                ->orderBy('id');
        }
        if (!empty($filter) and $filter==1 and empty($filter_category)){
            $query = CardVoice::find()
                ->where(['=','status', CardVoice::STATUS_ACTIVE])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==2 and empty($filter_category)){
            $query = CardVoice::find()
                ->andWhere(['=','status', CardVoice::STATUS_DEACTIVE])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==1 and !empty($filter_category)){
            $query = CardVoice::find()
                ->select('card_voice.*,category.name')
                ->joinWith('category')
                ->where(['=','status', CardVoice::STATUS_ACTIVE])
                ->andWhere(['=','category_id', $filter_category])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==2 and !empty($filter_category)){
            $query = CardVoice::find()
                ->select('card_voice.*,category.name')
                ->joinWith('category')
                ->where(['=','status', CardVoice::STATUS_DEACTIVE])
                ->andWhere(['=','category_id', $filter_category])
                ->orderBy('id');
        }
        return $query;
    }

    public static function get_random_card(){
        $result = Yii::$app->db->createCommand('SELECT *, card_voice.id as card_voice_id, page.id as page_id FROM card_voice JOIN category on card_voice.category_id=category.id join page on card_voice.id=page.card_id where card_voice.status = 0 order by card_voice.id limit 1')
            ->queryOne();
        return $result;
    }

    public static function get_random_page(){
        $result = Yii::$app->db->createCommand('SELECT * FROM page where status = 0 order by id limit 1')
            ->queryOne();
        return $result;
    }

    public static function update_page($request){
        try{
            $model = Page::findOne(['id' => $request[0]]);
            $model->description = $request[1];
            $model->keywords = $request[2];
            $model->title = $request[3];
            $model->text_h1 = $request[4];
            $model->status = $request[5];
            $model->save();
            $result = [
                "id" => $request[0],
                "status" => "success",
            ];
            return $result;
        }
        catch(Exception $e){
            $result = [
                "id" => $request[0],
                "status" => "error",
            ];
            return $result;
        }
    }
    public static function update_card($request){
            try{
                $model = CardVoice::findOne(['id' => $request[0]]);
                $model->voice_text_description = $request[1];
                $model->voice_text_theme = $request[2];
                $model->category_id = $request[3];
                $model->sex = $request[4];
                $model->status = $request[5];
                $model->save();
                $result = [
                    "id" => $request[0],
                    "status" => "success",
                ];
                return $result;
            }
            catch(Exception $e){
                $result = [
                    "id" => $request[0],
                    "status" => "error",
                ];
                return $result;
            }
    }

    public static function del_page($request)
    {
        $id = $request[0]['value'];
        try {
            if($id)
                Yii::$app->db->createCommand('DELETE FROM page where id=:id')
                    ->bindValue(':id', $id)
                    ->execute();
            $result = [
                "id" => $id,
                "status" => "success",
            ];
            return $result;
        }

        catch (Exception $e) {
            $result = [
                "id" => $id,
                "status" => "error",
                "message" => $e
            ];
            return $result;
        }
    }
    public static function del_card($request)
    {
        $id = $request[0]['value'];
        try {
            if($id)
            Yii::$app->db->createCommand('DELETE FROM card_voice where id=:id')
                ->bindValue(':id', $id)
                ->execute();
            $result = [
                "id" => $id,
                "status" => "success",
            ];
            return $result;
        }

        catch (Exception $e) {
        $result = [
            "id" => $id,
            "status" => "error",
            "message" => $e
        ];
            return $result;
        }
    }

    public static function save_card($request,$type){
        //сохранение
        if ($type == 1){
            try {
                if (empty($request[8]['value'])){
                    $date =  'NULL';
                }else{
                    $date = $request[8]['value'];
                }

                $model = CardVoice::findOne(['id' => $request[0]['value']]);
                $model->mp3_id = $request[1]['value'];
                $model->voice_text_description = $request[2]['value'];
                $model->voice_text_theme = $request[3]['value'];
                $model->voice_text_tags = $request[4]['value'];
                $model->sex = $request[5]['value'];
                $model->status = $request[6]['value'];
                $model->category_id = $request[7]['value'];
                $model->voice_date = $date;
                $model->save();
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }
        //добавление
        if ($type == 2){
            try {
                if (empty($request[8]['value'])){
                    $date =  'NULL';
                }else{
                    $date = $request[8]['value'];
                }
                $model = new CardVoice();
                $model->mp3_id = $request[1]['value'];
                $model->voice_text_description = $request[2]['value'];
                $model->voice_text_theme = $request[3]['value'];
                $model->voice_text_tags = $request[4]['value'];
                $model->sex = $request[5]['value'];
                $model->status = $request[6]['value'];
                $model->category_id = $request[7]['value'];
                $model->voice_date = $date;
                $model->save();
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }

    }
    public static function save_page($request,$type){

        //сохранение
        if ($type == 1){
            try {
                $model = Page::findOne(['id' => $request[0]['value']]);
                $model->card_id = $request[1]['value'];
                $model->url =  $request[2]['value'];
                $model->description = $request[3]['value'];
                $model->keywords = $request[4]['value'];
                $model->title = $request[5]['value'];
                $model->text_h1 = $request[6]['value'];
                $model->status = $request[7]['value'];
                $model->save();
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }
        //добавление
        if ($type == 2){
            try {
                $model = new Page();
                $model->card_id = $request[0]['value'];
                $model->url =  $request[1]['value'];
                $model->description = $request[2]['value'];
                $model->keywords = $request[3]['value'];
                $model->title = $request[4]['value'];
                $model->text_h1 = $request[5]['value'];
                $model->status = $request[6]['value'];
                $model->save();
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[0]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }

    }
}
