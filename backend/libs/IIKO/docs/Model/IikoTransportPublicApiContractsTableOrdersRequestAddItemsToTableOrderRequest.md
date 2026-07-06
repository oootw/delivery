# IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**add_order_items_settings** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddTableOrderItemsSettings**](IikoTransportPublicApiContractsTableOrdersRequestAddTableOrderItemsSettings.md) | Add order items parameters. | [optional]
**order_id** | **string** | Order ID. |
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem.md) | Order items (may include ProductOrderItem or CompoundOrderItem). |
**combos** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo.md) | Combos.   &gt; Allowed from version &#x60;7.6.1&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
