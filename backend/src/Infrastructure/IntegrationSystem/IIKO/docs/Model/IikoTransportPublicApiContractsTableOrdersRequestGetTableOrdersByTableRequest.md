# IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**source_keys** | **string[]** | Source keys. | [optional]
**organization_ids** | **string[]** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**table_ids** | **string[]** | Table IDs.                Can be obtained by &#x60;/api/1/reserve/available_restaurant_sections&#x60; operation. |
**statuses** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus.md) | Order statuses. | [optional]
**date_from** | **string** | Order creation date (terminal time zone). Lower limit.                Order details are stored for 90 days. | [optional]
**date_to** | **string** | Order creation date (terminal time zone). Upper limit. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
