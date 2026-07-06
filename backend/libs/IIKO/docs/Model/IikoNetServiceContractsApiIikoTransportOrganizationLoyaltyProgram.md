# IikoNetServiceContractsApiIikoTransportOrganizationLoyaltyProgram

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Program id. | [optional]
**name** | **string** | Program name. Can be null. | [optional]
**description** | **string** | Program description. Can be null. | [optional]
**service_from** | **string** | Program works since date. | [optional]
**service_to** | **string** | Program works till date. | [optional]
**notify_about_balance_changes** | **bool** | Notify customer when balance has changed (sms/push). | [optional]
**program_type** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportProgramType**](IikoNetServiceContractsApiIikoTransportProgramType.md) | Program type.  &lt;br&gt;0 - deposit or corporate nutrition,&lt;br /&gt;1 - bonus program,&lt;br /&gt;2 - products program,&lt;br /&gt;3 - discount program,&lt;br /&gt;4 - certificate program. | [optional]
**is_active** | **bool** | Program is active. | [optional]
**wallet_id** | **string** | Wallet id. Program has only wallet that means global payment type for customers. | [optional]
**marketing_campaigns** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignInfo[]**](IikoNetServiceContractsApiIikoTransportOrganizationMarketingCampaignInfo.md) | Program marketing campaigns. | [optional]
**applied_organizations** | **string[]** | Program applied organizations. | [optional]
**template_type** | [**\IIKO\Model\IikoNetCommonEnumsTemplateType**](IikoNetCommonEnumsTemplateType.md) | Program template type.  &lt;br&gt;0 - None,&lt;br /&gt;1 - BonusProgram,&lt;br /&gt;2 - DiscountProgram,&lt;br /&gt;3 - NthDishProgram,&lt;br /&gt;4 - ManualOrderAnonymousDiscount,&lt;br /&gt;5 - AutoOrderAnonymousDiscount,&lt;br /&gt;6 - AutoDishAnonymousDiscount,&lt;br /&gt;7 - PromotionsProgram,&lt;br /&gt;8 - NthDishPromotionsProgram. | [optional]
**is_exchange_rate_enabled** | **bool** | Exchange rate for bonuses and real currency. | [optional]
**refill_type** | [**\IIKO\Model\IikoNetCommonEnumsCounterMetric**](IikoNetCommonEnumsCounterMetric.md) | Refill type with payment. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
