<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KelompokRekening;

/**
* KelompokRekeningSearch represents the model behind the search form about `app\models\KelompokRekening`.
*/
class KelompokRekeningSearch extends KelompokRekening
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['nama', 'kelompok', 'jenis'], 'safe'],
];
}

/**
* @inheritdoc
*/
public function scenarios()
{
// bypass scenarios() implementation in the parent class
return Model::scenarios();
}

/**
* Creates data provider instance with search query applied
*
* @param array $params
*
* @return ActiveDataProvider
*/
public function search($params)
{
$query = KelompokRekening::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kelompok', $this->kelompok])
            ->andFilterWhere(['like', 'jenis', $this->jenis]);

return $dataProvider;
}
}