<?php
use kartik\select2\Select2;
use yii\easyii\widgets\Redactor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use grozzzny\widgets\switch_checkbox\SwitchCheckbox;

$module = $this->context->module->id;
?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= $this->render('@grozzzny/base_module/views/_image_file', ['model' => $current_model, 'attribute' => 'image_file'])?>
<?= $form->field($current_model, 'image_file')->fileInput() ?>

<?= $form->field($current_model, 'name') ?>

<?=$form->field($current_model, 'users')->widget(Select2::className(),[
    'data' => ArrayHelper::map($current_model->users, 'id', 'email'),
    'pluginOptions' => [
        'placeholder' => Yii::t('gr', 'Select users..'),
        'allowClear' => true,
        'multiple' => true,
        'ajax' => [
            'url' => '/admin/companies/ajax/get-users',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) {
               return {
                    q:params.term
                };
            }'),
        ],
    ],
]);
?>

<?=$form->field($current_model, 'admins')->widget(Select2::className(),[
    'data' => ArrayHelper::map($current_model->users, 'id', 'email'),
    'pluginOptions' => [
        'placeholder' => Yii::t('gr', 'Select users..'),
        'allowClear' => true,
        'multiple' => true,
        'ajax' => [
            'url' => '/admin/companies/ajax/get-users',
            'dataType' => 'json',
            'data' => new JsExpression('function(params) {
               return {
                    q:params.term
                };
            }'),
        ],
    ],
]);
?>

<?= $form->field($current_model, 'country') ?>
<?= $form->field($current_model, 'city') ?>
<?= $form->field($current_model, 'address') ?>
<?= $form->field($current_model, 'phone') ?>
<?= $form->field($current_model, 'email') ?>
<?= $form->field($current_model, 'site') ?>

<?= $form->field($current_model, 'description')->widget(Redactor::className(),[
    'options' => [
        'minHeight' => 200,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => Yii::$app->controller->module->id]),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => Yii::$app->controller->module->id]),
        'plugins' => ['fullscreen']
    ]
])?>

<?=SwitchCheckbox::widget([
    'model' => $current_model,
    'attributes' => [
        'status'
    ]
])?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>