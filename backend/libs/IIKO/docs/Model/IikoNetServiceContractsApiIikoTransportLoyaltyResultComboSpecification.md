# IikoNetServiceContractsApiIikoTransportLoyaltyResultComboSpecification

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**source_action_id** | **string** | Id of action that added the combo. | [optional]
**category_id** | **string** | Combo&#39;s category id. | [optional]
**name** | **string** | Name. Can be null. | [optional]
**price_modification_type** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultComboPriceModificationType**](IikoNetServiceContractsApiIikoTransportLoyaltyResultComboPriceModificationType.md) | Price modification type.  &lt;br&gt;0 - fixed combo price,&lt;br /&gt;1 - fixed position price,&lt;br /&gt;2 - cheapest position discount,&lt;br /&gt;3 - most expensive position discount,&lt;br /&gt;4 - percentage discount for each position. | [optional]
**price_modification** | **float** | Price modification. | [optional]
**is_active** | **bool** | Is active. | [optional]
**start_date** | **string** | Start date. | [optional]
**expiration_date** | **string** | Expiration date. | [optional]
**lacking_groups_to_suggest** | **int** | Lacking groups to suggest. | [optional]
**include_modifiers** | **bool** | Include modifiers. | [optional]
**groups** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroup[]**](IikoNetServiceContractsApiIikoTransportLoyaltyResultComboGroup.md) | Groups. | [optional]
**sort_order** | **int** | Sort order. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
