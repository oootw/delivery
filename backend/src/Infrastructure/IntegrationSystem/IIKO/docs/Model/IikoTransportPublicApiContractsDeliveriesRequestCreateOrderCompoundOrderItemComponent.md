# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCompoundOrderItemComponent

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product_id** | **string** | Item ID. |
**modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderModifier[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderModifier.md) | Modifiers. | [optional]
**price** | **float** | Price. | [optional]
**position_id** | **string** | Unique identifier of the item in the order.  MUST be unique for the whole system. Therefore it must be generated with Guid.NewGuid().  &gt; If sent null, it generates automatically on iikoTransport side. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
