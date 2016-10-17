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
    public static function get_card_all($filter){
        $query = CardVoice::find()
            ->select('card_voice.*,category.name')
            ->joinWith('category')
            ->orderBy('id');

        if (!empty($filter) and $filter==1){
            $query = CardVoice::find()
                ->where(['=','status', CardVoice::STATUS_ACTIVE])
                ->orderBy('id');
        }

        if (!empty($filter) and $filter==2){
            $query = CardVoice::find()
                ->andWhere(['=','status', CardVoice::STATUS_DEACTIVE])
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
                $model->voice_title = $request[1];
                $model->voice_text_h1 = $request[2];
                $model->voice_text_description = $request[3];
                $model->voice_text_theme = $request[4];
                $model->sex = $request[5];
                $model->status = $request[6];
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
    public static function save_card($request){
            try {
                $date = explode('/', $request[12]['value']);
                $date = $date[2] . "-" . $date[0] . "-" . $date[1] . " 00:00:00";
                $model = CardVoice::findOne(['id' => $request[1]['value']]);
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
