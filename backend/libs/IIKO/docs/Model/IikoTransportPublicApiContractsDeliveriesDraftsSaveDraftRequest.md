# IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**employee_id** | **string** | ID of the employee who wants to update order draft. |
**organization_id** | **string** | Organization ID of the new order.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft**](IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft.md) | Order item. |
**terminal_group_id** | **string** | Front group ID the order must be sent to.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
