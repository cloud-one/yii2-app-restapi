<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $client_id
 * @property int $master_client_id This should be used to link clients to a master for lookups, like Dukky has 5 child clients
 * @property int $parent_client_id
 * @property int $status 0 = Paused, 1 = Active, 2 = Pending, 3 = Cancelled,  4 = Billing Issue
 * @property string $company
 * @property string $dba
 * @property string $address
 * @property string $address2
 * @property string $zip
 * @property string $city
 * @property string $state
 * @property string $daterange
 * @property int $phone_company
 * @property int $phone_fax
 * @property string $website
 * @property string $time_zone
 * @property string $api_key
 * @property string $default_answer_as
 * @property string $privacy_policy_url
 * @property string $purl
 * @property string $purl_buyback
 * @property int $logo
 * @property int $can_view_calls
 * @property int $can_download_calls
 * @property int $customers_can_view_calls
 * @property string $billing_name_last
 * @property string $billing_name_first
 * @property string $billing_address1
 * @property string $billing_address2
 * @property string $billing_zip
 * @property string $billing_city
 * @property string $billing_state
 * @property string $billing_email
 * @property int $billing_phone
 * @property int $billing_phone_ext
 * @property int $billing_fax
 * @property string $billing_notes
 * @property string $customer_login
 * @property string $client_domain
 * @property string $custom_dir
 * @property int $can_edit_leads
 * @property int $can_create_campaigns
 * @property int $campaign_form 1 = generic form, 2 = direct mail
 * @property int $sales_manager
 * @property int $production_manager
 * @property int $account_manager
 * @property int $performance_manager
 * @property int $billing_frequency
 * @property int $billing_terms
 * @property int $billing_id
 * @property int $implementation_specialist
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_client_id', 'company', 'dba', 'address', 'address2', 'zip', 'city', 'state', 'phone_company', 'phone_fax', 'website', 'api_key', 'privacy_policy_url', 'purl', 'purl_buyback', 'logo', 'can_view_calls', 'customers_can_view_calls', 'billing_name_last', 'billing_name_first', 'billing_address1', 'billing_address2', 'billing_zip', 'billing_city', 'billing_state', 'billing_email', 'billing_phone', 'billing_phone_ext', 'billing_fax', 'billing_notes', 'customer_login', 'client_domain', 'custom_dir', 'sales_manager', 'production_manager', 'account_manager', 'performance_manager', 'billing_frequency', 'billing_terms', 'billing_id', 'implementation_specialist'], 'required'],
            [['master_client_id', 'parent_client_id', 'status', 'phone_company', 'phone_fax', 'logo', 'can_view_calls', 'can_download_calls', 'customers_can_view_calls', 'billing_phone', 'billing_phone_ext', 'billing_fax', 'can_edit_leads', 'can_create_campaigns', 'campaign_form', 'sales_manager', 'production_manager', 'account_manager', 'performance_manager', 'billing_frequency', 'billing_terms', 'billing_id', 'implementation_specialist'], 'integer'],
            [['daterange'], 'safe'],
            [['billing_notes'], 'string'],
            [['company', 'dba', 'address', 'address2', 'billing_address1', 'billing_address2'], 'string', 'max' => 100],
            [['zip', 'billing_zip'], 'string', 'max' => 10],
            [['city', 'billing_city'], 'string', 'max' => 30],
            [['state', 'billing_state'], 'string', 'max' => 2],
            [['website', 'customer_login'], 'string', 'max' => 255],
            [['time_zone', 'custom_dir'], 'string', 'max' => 20],
            [['api_key'], 'string', 'max' => 32],
            [['default_answer_as', 'billing_name_last', 'billing_name_first', 'client_domain'], 'string', 'max' => 50],
            [['privacy_policy_url', 'purl', 'purl_buyback', 'billing_email'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
            'master_client_id' => 'Master Client ID',
            'parent_client_id' => 'Parent Client ID',
            'status' => 'Status',
            'company' => 'Company',
            'dba' => 'Dba',
            'address' => 'Address',
            'address2' => 'Address2',
            'zip' => 'Zip',
            'city' => 'City',
            'state' => 'State',
            'daterange' => 'Daterange',
            'phone_company' => 'Phone Company',
            'phone_fax' => 'Phone Fax',
            'website' => 'Website',
            'time_zone' => 'Time Zone',
            'api_key' => 'Api Key',
            'default_answer_as' => 'Default Answer As',
            'privacy_policy_url' => 'Privacy Policy Url',
            'purl' => 'Purl',
            'purl_buyback' => 'Purl Buyback',
            'logo' => 'Logo',
            'can_view_calls' => 'Can View Calls',
            'can_download_calls' => 'Can Download Calls',
            'customers_can_view_calls' => 'Customers Can View Calls',
            'billing_name_last' => 'Billing Name Last',
            'billing_name_first' => 'Billing Name First',
            'billing_address1' => 'Billing Address1',
            'billing_address2' => 'Billing Address2',
            'billing_zip' => 'Billing Zip',
            'billing_city' => 'Billing City',
            'billing_state' => 'Billing State',
            'billing_email' => 'Billing Email',
            'billing_phone' => 'Billing Phone',
            'billing_phone_ext' => 'Billing Phone Ext',
            'billing_fax' => 'Billing Fax',
            'billing_notes' => 'Billing Notes',
            'customer_login' => 'Customer Login',
            'client_domain' => 'Client Domain',
            'custom_dir' => 'Custom Dir',
            'can_edit_leads' => 'Can Edit Leads',
            'can_create_campaigns' => 'Can Create Campaigns',
            'campaign_form' => 'Campaign Form',
            'sales_manager' => 'Sales Manager',
            'production_manager' => 'Production Manager',
            'account_manager' => 'Account Manager',
            'performance_manager' => 'Performance Manager',
            'billing_frequency' => 'Billing Frequency',
            'billing_terms' => 'Billing Terms',
            'billing_id' => 'Billing ID',
            'implementation_specialist' => 'Implementation Specialist',
        ];
    }
}
