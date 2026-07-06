# IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**reserve_id** | **string** | Banquet ID. |
**items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem.md) | Order items (may include ProductOrderItem or CompoundOrderItem). | [optional]
**combos** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo.md) | Combos. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
