<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/**
 * @var string $word
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
$this->title = 'Seach by: '.$word;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?= ListView::widget(
                [
                    'dataProvider' => $dataProvider,

                    'layout'       => '{items}{pager}',
                    'itemView'     => '_wallet_item',
                ]
            );?>
        </div>
    </div>
</div>
