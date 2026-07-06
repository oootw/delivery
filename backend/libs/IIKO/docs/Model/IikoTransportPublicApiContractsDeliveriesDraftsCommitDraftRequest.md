# IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID of the new order.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**terminal_group_id** | **string** | Front group ID the order must be sent to.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. | [optional]
**create_order_settings** | [**\IIKO\Model\IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings**](IikoTransportPublicApiContractsOrdersCommonCreateOrderSettings.md) | Order creation parameters. | [optional]
**order_id** | **string** | ID of the order. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
