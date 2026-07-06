# IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID. Deprecated, use \&quot;organizationIds\&quot;. | [optional]
**organization_ids** | **string[]** | Organization IDs.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. | [optional]
**delivery_address** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsAddress**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsAddress.md) | Delivery address. | [optional]
**order_location** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonCoordinates**](IikoTransportPublicApiContractsDeliveriesCommonCoordinates.md) | Order location. | [optional]
**order_items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItem[]**](IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsRestrictionsOrderItem.md) | Order list. | [optional]
**is_courier_delivery** | **bool** | Type of delivery service. |
**delivery_date** | **string** | Delivery date (Local for delivery terminal). | [optional]
**delivery_sum** | **float** | Sum. | [optional]
**discount_sum** | **float** | Discounts sum. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
