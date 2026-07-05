# IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**order_id** | **string** | Order ID. |
**delivery_status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatusForUpdate**](IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatusForUpdate.md) | Delivery status. Can be only switched between these three statuses. |
**delivery_date** | **string** | The date and time when the order was received by the guest (Local for delivery terminal). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
