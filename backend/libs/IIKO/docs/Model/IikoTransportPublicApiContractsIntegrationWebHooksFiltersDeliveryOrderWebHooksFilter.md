# IikoTransportPublicApiContractsIntegrationWebHooksFiltersDeliveryOrderWebHooksFilter

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**order_statuses** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus[]**](IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus.md) | Statuses of orders, when changing which need to send a notification. | [optional]
**item_statuses** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus.md) | Statuses of order items, when changing which need to send a notification. | [optional]
**errors** | **bool** | Flag for errors. | [optional]
**returned_external_data_keys** | **string[]** | Order external data keys to return in a notification. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
