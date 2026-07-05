# IikoTransportPublicApiContractsReservesRequestReserveOrder

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**menu_id** | **string** | External menu ID. | [optional]
**items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem.md) | Order items. |
**combos** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo.md) | Combos included in order. | [optional]
**payments** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment.md) | Order payment components.   &gt; Type **LoyaltyCard** allowed from version &#x60;7.1.5&#x60;. | [optional]
**tips** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment.md) | Order tips components. | [optional]
**source_key** | **string** | The string key (marker) of the source (partner - api user) that created the order. Needed to limit the visibility of orders for external integration. | [optional]
**discounts_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo.md) | Discounts/surcharges. | [optional]
**loyalty_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo.md) | Information about Loyalty app. | [optional]
**order_type_id** | **string** | Order type ID.                 Can be obtained by &#x60;/api/1/deliveries/order_types&#x60; operation | [optional]
**cheque_additional_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo**](IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo.md) | Cheque additional information. | [optional]
**external_data** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData.md) | Order external data.   &gt; Allowed from version &#x60;8.0.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
