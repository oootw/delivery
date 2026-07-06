# IikoTransportPublicApiContractsDeliveriesResponseOrderProductOrderItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Item. |
**modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier.md) | Modifiers. | [optional]
**codes** | **\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemIdentifierCode[][]** | List of product codes. Each outer list item represents a separate product unit;  each inner list contains codes associated with that unit.   &gt; Allowed from version &#x60;9.2.6&#x60;. | [optional]
**price** | **float** | Price per item unit. Can be sent different from the price in the base menu. |
**cost** | **float** | Total cost per item without tax, discounts/surcharges. |
**price_predefined** | **bool** | Whether price is predefined. |
**position_id** | **string** | Unique identifier of the item in the order and for the whole system. | [optional]
**tax_percent** | **float** | Tax rate. | [optional]
**result_sum** | **float** | Total amount per item including tax, discounts/surcharges. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
