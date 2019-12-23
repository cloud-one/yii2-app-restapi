<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leads_activation".
 *
 * @property int $campaign_id
 * @property float $new_loan_apr
 * @property string $name_first
 * @property string $name_last
 * @property string $name_first_soundex
 * @property string $name_last_soundex
 * @property string $address
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property int $phone
 * @property string $year
 * @property string $make
 * @property string $model
 * @property int $car_id
 * @property int $ecar_id
 * @property int $etrim_id
 * @property int $model_id
 * @property int $style_id
 * @property int $vehicle_id
 * @property int $trim_id
 * @property float $our_offer
 * @property float $value_rough
 * @property float $value_average
 * @property float $value_clean
 * @property int $score
 * @property string $notes
 * @property string $activation_code
 * @property string $daterange
 * @property string $custom1
 * @property string $custom2
 * @property string $custom3
 * @property string $custom4
 * @property string $custom5
 * @property string $marketing_method
 * @property string $current_loan_type Lease or Loan
 * @property int $current_loan_remaining_months
 * @property float $current_payment
 * @property string $new_year
 * @property string $new_make
 * @property string $new_model
 * @property string $new_trim
 * @property int $new_ecar_id
 * @property int $new_etrim_id
 * @property int $new_vehicle_id
 * @property int $new_trim_id
 * @property string $new_loan_type Lease or Loan
 * @property int $new_loan_months
 * @property float $new_loan_payment
 * @property float $new_loan_down_payment
 * @property int $phone_2
 * @property string $vin
 * @property string $email
 */
class LeadsActivation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_activation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campaign_id'], 'required'],
            [['campaign_id', 'phone', 'car_id', 'ecar_id', 'etrim_id', 'model_id', 'style_id', 'vehicle_id', 'trim_id', 'score', 'current_loan_remaining_months', 'new_ecar_id', 'new_etrim_id', 'new_vehicle_id', 'new_trim_id', 'new_loan_months', 'phone_2'], 'integer'],
            [['new_loan_apr', 'our_offer', 'value_rough', 'value_average', 'value_clean', 'current_payment', 'new_loan_payment', 'new_loan_down_payment'], 'number'],
            [['year', 'daterange', 'new_year'], 'safe'],
            [['name_first', 'name_last', 'address2', 'city', 'model'], 'string', 'max' => 30],
            [['name_first_soundex', 'name_last_soundex', 'activation_code', 'new_make', 'new_model', 'new_trim'], 'string', 'max' => 50],
            [['address', 'email'], 'string', 'max' => 100],
            [['state'], 'string', 'max' => 2],
            [['zip', 'marketing_method'], 'string', 'max' => 10],
            [['make'], 'string', 'max' => 15],
            [['notes', 'custom1', 'custom2', 'custom3', 'custom4', 'custom5'], 'string', 'max' => 255],
            [['current_loan_type', 'new_loan_type'], 'string', 'max' => 5],
            [['vin'], 'string', 'max' => 17],
            [['campaign_id', 'activation_code'], 'unique', 'targetAttribute' => ['campaign_id', 'activation_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'campaign_id' => 'Campaign ID',
            'new_loan_apr' => 'New Loan Apr',
            'name_first' => 'Name First',
            'name_last' => 'Name Last',
            'name_first_soundex' => 'Name First Soundex',
            'name_last_soundex' => 'Name Last Soundex',
            'address' => 'Address',
            'address2' => 'Address2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'phone' => 'Phone',
            'year' => 'Year',
            'make' => 'Make',
            'model' => 'Model',
            'car_id' => 'Car ID',
            'ecar_id' => 'Ecar ID',
            'etrim_id' => 'Etrim ID',
            'model_id' => 'Model ID',
            'style_id' => 'Style ID',
            'vehicle_id' => 'Vehicle ID',
            'trim_id' => 'Trim ID',
            'our_offer' => 'Our Offer',
            'value_rough' => 'Value Rough',
            'value_average' => 'Value Average',
            'value_clean' => 'Value Clean',
            'score' => 'Score',
            'notes' => 'Notes',
            'activation_code' => 'Activation Code',
            'daterange' => 'Daterange',
            'custom1' => 'Custom1',
            'custom2' => 'Custom2',
            'custom3' => 'Custom3',
            'custom4' => 'Custom4',
            'custom5' => 'Custom5',
            'marketing_method' => 'Marketing Method',
            'current_loan_type' => 'Current Loan Type',
            'current_loan_remaining_months' => 'Current Loan Remaining Months',
            'current_payment' => 'Current Payment',
            'new_year' => 'New Year',
            'new_make' => 'New Make',
            'new_model' => 'New Model',
            'new_trim' => 'New Trim',
            'new_ecar_id' => 'New Ecar ID',
            'new_etrim_id' => 'New Etrim ID',
            'new_vehicle_id' => 'New Vehicle ID',
            'new_trim_id' => 'New Trim ID',
            'new_loan_type' => 'New Loan Type',
            'new_loan_months' => 'New Loan Months',
            'new_loan_payment' => 'New Loan Payment',
            'new_loan_down_payment' => 'New Loan Down Payment',
            'phone_2' => 'Phone 2',
            'vin' => 'Vin',
            'email' => 'Email',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LeadsActivationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LeadsActivationQuery(get_called_class());
    }
}
