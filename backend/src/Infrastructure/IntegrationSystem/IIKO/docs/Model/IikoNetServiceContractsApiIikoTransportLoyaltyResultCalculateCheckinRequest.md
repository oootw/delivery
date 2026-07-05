# IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrder**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrder.md) | Order. |
**coupon** | **string** | Obsolete field. Use Order.LoyaltyInfo.Coupon instead. Can be null. | [optional]
**referrer_id** | **string** | Referrer id. | [optional]
**terminal_group_id** | **string** | Identifier of a target terminal. Should be used only when auto distribution is off and no call center operator is available. | [optional]
**available_payment_marketing_campaign_ids** | **string[]** | List of identifiers of applied campaigns. Should be empty if no payment method is used. | [optional]
**applicable_manual_conditions** | **string[]** | Obsolete field. Use request.Order.LoyaltyInfo.ApplicableManualConditions instead. | [optional]
**dynamic_discounts** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultDynamicDiscount[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultDynamicDiscount.md) | Obsolete field. Use Order.LoyaltyInfo.DynamicDiscounts instead. Can be null.. | [optional]
**is_loyalty_trace_enabled** | **bool** | Loyalty trace is enabled. | [optional]
**organization_id** | **string** | Organization id. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
