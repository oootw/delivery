# IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**source_keys** | **string[]** | Source keys. | [optional]
**organization_ids** | **string[]** | Organization IDs.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**order_ids** | **string[]** | Order IDs.                &gt; Required if \&quot;posOrderIds\&quot; is null. Must be null if \&quot;posOrderIds\&quot; is not null. | [optional]
**pos_order_ids** | **string[]** | POS order IDs.                &gt; Required if \&quot;orderIds\&quot; is null. Must be null if \&quot;orderIds\&quot; is not null. | [optional]
**return_external_data_keys** | **string[]** | Keys for retrun external data information. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
