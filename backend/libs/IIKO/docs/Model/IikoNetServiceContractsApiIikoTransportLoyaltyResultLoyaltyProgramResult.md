# IikoNetServiceContractsApiIikoTransportLoyaltyResultLoyaltyProgramResult

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**marketing_campaign_id** | **string** | Program marketing campaign id. | [optional]
**name** | **string** | Program name. | [optional]
**discounts** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultDiscountOperation[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultDiscountOperation.md) | Discount operations applied to order items. | [optional]
**upsales** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsale[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultUpsale.md) | Suggested items to add or advices for customer. | [optional]
**free_products** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductsGroup[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultFreeProductsGroup.md) | Program free products. | [optional]
**available_combo_specifications** | **string[]** | Ids of combo specification available in current order. | [optional]
**available_combos** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailableCombo[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultAvailableCombo.md) | Partially added combos, available for assembly. | [optional]
**need_to_activate_certificate** | **bool** | Certificate number is required for activation. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
