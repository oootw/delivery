# IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Marketing campaign id. | [optional]
**program_id** | **string** | Loyalty program id. | [optional]
**name** | **string** | Loyalty program name. Can be null. | [optional]
**description** | **string** | Marketing campaign description. Can be null. | [optional]
**is_active** | **bool** | Marketing campaign is active. | [optional]
**period_from** | **string** | Marketing campaign works since date. | [optional]
**period_to** | **string** | Marketing campaign works till date. Null means limitless. | [optional]
**order_action_condition_bindings** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo[]**](IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo.md) | Conditions and actions that will be checked when order is processed. | [optional]
**periodic_action_condition_bindings** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo[]**](IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo.md) | Conditions and actions that will be checked by schedule. | [optional]
**overdraft_action_condition_bindings** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo[]**](IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo.md) | Conditions and actions that will be checked by overdraft. | [optional]
**guest_registration_action_condition_bindings** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo[]**](IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignActionConditionBindingInfo.md) | Conditions and actions that will be checked by guest registration. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
