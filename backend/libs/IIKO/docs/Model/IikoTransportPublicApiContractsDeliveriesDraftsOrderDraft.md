# IikoTransportPublicApiContractsDeliveriesDraftsOrderDraft

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Order ID. |
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**locked_by_user** | **string** | ID of the employee, who is editing this draft. | [optional]
**locked_at** | **string** | Timestamp of when the draft was taken for editing (lock). | [optional]
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft**](IikoTransportPublicApiContractsDeliveriesDraftsDeliveryOrderDraft.md) | Order. |
**terminal_group_id** | **string** | Terminal group ID. | [optional]
**created_at** | **string** | Draft creation time (UTC). |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
