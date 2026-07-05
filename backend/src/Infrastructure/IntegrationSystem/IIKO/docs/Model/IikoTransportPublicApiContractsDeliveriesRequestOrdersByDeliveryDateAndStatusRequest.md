# IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_ids** | **string[]** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**delivery_date_from** | **string** | Order delivery date (Local for delivery terminal). Lower limit.                The guaranteed order availability period is the last 7 days. To access earlier orders, use the &#x60;/api/1/deliveries/history/by_delivery_date_and_phone&#x60; method. |
**delivery_date_to** | **string** | Order delivery date (Local for delivery terminal). Upper limit. | [optional]
**statuses** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus[]**](IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus.md) | Allowed order statuses. | [optional]
**source_keys** | **string[]** | Source keys. | [optional]
**courier_ids** | **string[]** | List of driver IDs. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
