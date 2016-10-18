<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\CardVoice;
/**
 * Login form
 */
class Db extends Model
{
    public static function get_card_one($result){
        $result = Yii::$app->db->createCommand('SELECT *, card_voice.id as card_voice_id FROM card_voice JOIN category on card_voice.category_id=category.id where  card_voice.id=:id order by card_voice.id limit 1')
        ->bindValue(':id', $result)
        ->queryOne();
        return $result;
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
        $result = Yii::$app->db->createCommand('SELECT *, card_voice.id as card_voice_id FROM card_voice JOIN category on card_voice.category_id=category.id where status = 0 order by card_voice.id limit 1')
            ->queryOne();
        return $result;
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
    public static function del_card($request)
    {
        try {
            if($request[1]['value'])
            Yii::$app->db->createCommand('DELETE FROM card_voice where id=:id')
                ->bindValue(':id', $request[1]['value'])
                ->execute();
            $result = [
                "id" => $request[1]['value'],
                "status" => "success",
            ];
            return $result;
        }

        catch (Exception $e) {
        $result = [
            "id" => $request[1]['value'],
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
                $date = explode('/', $request[8]['value']);
                $date = $date[2] . "-" . $date[0] . "-" . $date[1] . " 00:00:00";

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
                    "id" => $request[1]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[1]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }
        //добавление
        if ($type == 2){
            try {
                $date = explode('/', $request[12]['value']);
                $date = $date[2] . "-" . $date[0] . "-" . $date[1] . " 00:00:00";
                $model = new CardVoice();
                $model->url = $request[0]['value'];
                $model->mp3_id = $request[2]['value'];
                $model->voice_description = $request[3]['value'];
                $model->voice_keywords = $request[4]['value'];
                $model->voice_title = $request[5]['value'];
                $model->voice_text_h1 = $request[6]['value'];
                $model->voice_text_description = $request[7]['value'];
                $model->voice_text_theme = $request[8]['value'];
                $model->voice_text_tags = $request[9]['value'];
                $model->sex = $request[10]['value'];
                $model->category_id = $request[11]['value'];
                $model->voice_date = $date;
                $model->status = 1;
                $model->save();
                $result = [
                    "id" => $request[1]['value'],
                    "status" => "success",
                ];
                return $result;
            } catch (Exception $e) {
                $result = [
                    "id" => $request[1]['value'],
                    "status" => "error",
                    "message" => $e
                ];
                return $result;
            }
        }

    }
}
