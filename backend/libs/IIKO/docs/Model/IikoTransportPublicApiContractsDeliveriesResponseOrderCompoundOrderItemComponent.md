# IikoTransportPublicApiContractsDeliveriesResponseOrderCompoundOrderItemComponent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Item. |
**modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier.md) | Modifiers. | [optional]
**price** | **float** | Price per item unit. Can be sent different from the price in the base menu. |
**cost** | **float** | Item total including tax, discounts/surcharges. |
**price_predefined** | **bool** | Whether price is predefined. |
**position_id** | **string** | Unique identifier of the item in the order and for the whole system. | [optional]
**tax_percent** | **float** | Tax rate. | [optional]
**result_sum** | **float** | Total amount per item including tax, discounts/surcharges. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
