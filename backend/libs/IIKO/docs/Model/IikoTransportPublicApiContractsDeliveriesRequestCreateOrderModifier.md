# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderModifier

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**product_id** | **string** | Modifier item ID.                Can be obtained by &#x60;/api/1/nomenclature&#x60; operation. |
**amount** | **float** | Quantity. |
**product_group_id** | **string** | Modifiers group ID (for group modifier). Required for a group modifier.                Can be obtained by &#x60;/api/1/nomenclature&#x60; operation. | [optional]
**price** | **float** | Unit price. | [optional]
**position_id** | **string** | Unique identifier of the item in the order.  MUST be unique for the whole system. Therefore it must be generated with Guid.NewGuid().  &gt; If sent null, it generates automatically on iikoTransport side. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
