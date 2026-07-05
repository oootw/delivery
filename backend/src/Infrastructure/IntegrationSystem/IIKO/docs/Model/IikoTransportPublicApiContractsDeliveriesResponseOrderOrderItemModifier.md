# IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemModifier

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Item. |
**amount** | **float** | Quantity. |
**amount_independent_of_parent_amount** | **bool** | Whether quantity of modifier depends on quantity of item. |
**codes** | **\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemIdentifierCode[][]** | List of product codes. Each outer list item represents a separate product unit;  each inner list contains codes associated with that unit.   &gt; Allowed from version &#x60;9.3.6&#x60;. | [optional]
**product_group** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Group of modifiers (in case of a group modifier). | [optional]
**price** | **float** | Price per item unit. Can be sent different from the price in RMS. |
**price_predefined** | **bool** | Whether price is predefined. |
**result_sum** | **float** | Total amount per item including tax, discounts/surcharges. |
**deleted** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo.md) | Item deletion details. If specified, the item is deleted. | [optional]
**position_id** | **string** | Unique identifier of the item in the order and for the whole system. | [optional]
**default_amount** | **int** | Default amount. | [optional]
**hide_if_default_amount** | **bool** | Hide modifier in UI if \&quot;amount\&quot; equals \&quot;defaultAmount\&quot;. | [optional]
**tax_percent** | **float** | Tax rate. | [optional]
**free_of_charge_amount** | **int** | Free of charge amount. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
