# IikoTransportPublicApiContractsReservesReserve

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**customer** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer**](IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer.md) | Client that placed the reserve. |
**guests_count** | **int** | Estimated guests count. |
**comment** | **string** | Optional comment for reserve or banquet. | [optional]
**duration_in_minutes** | **int** | Estimated banquet duration. |
**should_remind** | **bool** | Whether to remind staff to prepare table beforehand. |
**status** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesReserveStatus**](IikoTransportPublicApiContractsReservesReserveStatus.md) | Status of the reserve or banquet. |
**cancel_reason** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesReserveCancelReason**](IikoTransportPublicApiContractsReservesReserveCancelReason.md) | The reserve cancellation reason or null if the reserve hasn&#39;t been canceled. | [optional]
**table_ids** | **string[]** | Reserved table IDs. |
**estimated_start_time** | **string** | Estimated time when reserve will be closed or banquet will be started. |
**guests_coming_time** | **string** | Time when guests came and reserve was closed or banquet was started. | [optional]
**phone** | **string** | Telephone number. | [optional]
**event_type** | **string** | Event type.   &gt; Allowed from version &#x60;8.5.6&#x60;. | [optional]
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesResponseReserveOrder**](IikoTransportPublicApiContractsReservesResponseReserveOrder.md) | Order. Used only at a banquet. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
