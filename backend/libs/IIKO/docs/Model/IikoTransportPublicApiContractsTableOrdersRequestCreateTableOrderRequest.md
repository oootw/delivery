# IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**terminal_group_id** | **string** | Front group ID an order must be sent to.                Can be obtained by &#x60;/api/1/terminal_groups&#x60; operation. |
**order** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestTableOrder**](IikoTransportPublicApiContractsTableOrdersRequestTableOrder.md) | Order. | [optional]
**create_order_settings** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderSettings**](IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderSettings.md) | Order creation parameters. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
