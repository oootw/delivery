# IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**order_id** | **string** | Order ID. |
**moved_order_id** | **string** | Fill this field with id of the new order if current order has been moved to the new RMS/terminal group. | [optional]
**cancel_cause_id** | **string** | Cancel order dictionary item id.   &gt; Allowed from version &#x60;7.7.1&#x60;. | [optional]
**cancel_comment** | **string** | Comment to the delivery cancellation.   &gt; Allowed from version &#x60;8.7.6&#x60;. | [optional]
**removal_type_id** | **string** | Removal type (for delete printed order items).   &gt; Allowed from version &#x60;7.7.1&#x60;. | [optional]
**removal_comment** | **string** | Comment to the charge-off.   &gt; Allowed from version &#x60;8.7.6&#x60;. | [optional]
**user_id_for_writeoff** | **string** | User for writeoff (for delete printed order items).   &gt; Allowed from version &#x60;7.7.1&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
