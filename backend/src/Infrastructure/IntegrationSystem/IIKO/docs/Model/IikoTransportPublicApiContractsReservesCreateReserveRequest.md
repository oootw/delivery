# IikoTransportPublicApiContractsReservesCreateReserveRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID of a new banquet/reserve.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**terminal_group_id** | **string** | Front group ID an banquet/reserve must be sent to.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. | [optional]
**id** | **string** | Banquet/reserve ID. Must be unique. | [optional]
**external_number** | **string** | Banquet/reserve external number.   &gt; Allowed from version &#x60;8.0.6&#x60;. | [optional]
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesRequestReserveOrder**](IikoTransportPublicApiContractsReservesRequestReserveOrder.md) | Order. Used only at a banquet. | [optional]
**customer** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRegularCustomer**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRegularCustomer.md) | Customer. |
**phone** | **string** | Telephone number.  &gt; Must begin with symbol \&quot;+\&quot; and must be at least 8 digits. |
**guests_count** | **int** | Number of guests. | [optional]
**comment** | **string** | Banquet/reserve comment. | [optional]
**duration_in_minutes** | **int** | Estimated banquet duration. |
**should_remind** | **bool** | Whether to remind staff to prepare table beforehand. |
**table_ids** | **string[]** | Reserved tables. |
**estimated_start_time** | **string** | Estimated time when reserve will be closed or banquet will be started (Local for the terminal).  Reservation can be made up to 90 days prior to the date. |
**transport_to_front_timeout** | **int** | Timeout in seconds that specifies how much time is given for banquet/reserve to reach iikoFront.   After this time, banquet/reserve is nullified if iikoFront doesn&#39;t take it. By default - 8 seconds. | [optional]
**guests** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesGuestsInfo**](IikoTransportPublicApiContractsReservesGuestsInfo.md) | Guests information. | [optional]
**event_type** | **string** | Event type.   &gt; Allowed from version &#x60;8.5.6&#x60;. | [optional]
**create_reserve_settings** | [**\IIKO\Model\IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings**](IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings.md) | Reserve creation parameters. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
