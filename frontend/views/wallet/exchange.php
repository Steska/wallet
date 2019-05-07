<?php
/**
 * @var \common\models\Wallet[] $myWallets
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
$data = [];
foreach ($myWallets as $myWallet){
    $data[$myWallet->id] = $myWallet->name.' '.$myWallet->currency->short;
}
$urlList = \yii\helpers\Url::to(['wallet/list']);
?>

<div class="currency-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'exchange-form',
                                             'enableAjaxValidation' => true,
                                             'enableClientValidation' => false,
                                             'validationUrl' => \yii\helpers\Url::to(['wallet/exchange'])
            ]); ?>


            <?=$form->field($model, 'walletSender')->widget(\kartik\select2\Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Select a your Wallet ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>

            <?=$form->field($model, 'walletReceiver')->widget(Select2::className(),
                [
                    'options'       => [
                        'placeholder' => 'Search a wallet',
                        'multiple'    => false,
                    ],
                    'pluginOptions' => [
                        'allowClear'         => true,
                        'minimumInputLength' => 3,
                        'language'           => [
                            'errorLoading' => new \yii\web\JsExpression(
                                "function () { return 'Waiting for results...'; }"
                            ),
                        ],
                        'ajax'               => [
                            'url'      => $urlList,
                            'dataType' => 'json',
                            'data'     => new \yii\web\JsExpression(
                                'function(params) {
                                                                    return {
                                                                      q:params.term,
                                                                        };
                                                                    }'
                            ),
                        ],
                        'escapeMarkup'       => new \yii\web\JsExpression('function (markup) { return markup; }'),
                        'templateResult'     => new \yii\web\JsExpression(
                            'function (category) {
                                                                        return category.text;
                                                                      }'
                        ),
                        'templateSelection'  => new \yii\web\JsExpression(
                            'function (category) {
                                                                        return category.text;
                                                                      }'
                        ),
                    ],
                ]
                )?>
            <?=$form->field($model, 'amount')->textInput()?>
            <div id="convert-data"></div>
            <div class="form-group">
                <?=Html::button('Show rates', ['id' => 'show-rates', 'class' => 'btn btn-primary', 'data-url' => \yii\helpers\Url::to(['wallet/show-rates'])])?>
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

