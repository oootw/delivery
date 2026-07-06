# IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**order_ids** | **string[]** | IDs of orders information on which is required.                &gt; Required if \&quot;posOrderIds\&quot; is null. Must be null if \&quot;posOrderIds\&quot; is not null.                &gt; Maximum allowed \&quot;orderIds\&quot; to request - &#x60;200&#x60;.    The guaranteed order availability period is the last 7 days. To access earlier orders, use the &#x60;/api/1/deliveries/history/by_delivery_date_and_phone&#x60; method. | [optional]
**source_keys** | **string[]** | Source keys. | [optional]
**pos_order_ids** | **string[]** | POS order IDs information on which is required.                &gt; Required if \&quot;orderIds\&quot; is null. Must be null if \&quot;orderIds\&quot; is not null.                &gt; Maximum allowed \&quot;posOrderIds\&quot; to request - &#x60;200&#x60;.    The guaranteed order availability period is the last 7 days. To access earlier orders, use the &#x60;/api/1/deliveries/history/by_delivery_date_and_phone&#x60; method. | [optional]
**return_external_data_keys** | **string[]** | Keys for retrun external data information. | [optional]
**return_locked_by_user** | **bool** | Whether to check and return LockedByUser property (see FullOrderUpdateRequest.EmployeeId). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
