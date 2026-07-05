# IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**start_revision** | **int** | Revision start number beginning from which (but not including) new/edited orders will be returned.                &gt; Maximum revision offset to request - &#x60;3 hours&#x60;. |
**organization_ids** | **string[]** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**source_keys** | **string[]** | Source keys. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
