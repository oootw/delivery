# IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | **string** |  |
**status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItemStatus.md) | Item cooking status. |
**deleted** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderItemDeletedInfo.md) | Item deletion details. If filled up, item is deleted. | [optional]
**amount** | **float** | Quantity. |
**comment** | **string** | Comment. | [optional]
**when_printed** | **string** | Printing time (Local for the terminal). | [optional]
**size** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Size. | [optional]
**combo_information** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderComboItemInformation**](IikoTransportPublicApiContractsDeliveriesResponseOrderComboItemInformation.md) | Combo details, if order item is part of combo. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
