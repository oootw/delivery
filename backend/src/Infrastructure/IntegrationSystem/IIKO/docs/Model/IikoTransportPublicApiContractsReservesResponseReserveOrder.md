# IikoTransportPublicApiContractsReservesResponseReserveOrder

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**menu_id** | **string** | External menu ID. | [optional]
**sum** | **float** | Order amount (after discount or surcharge). |
**number** | **int** | Delivery No. |
**source_key** | **string** | Delivery source. | [optional]
**when_bill_printed** | **string** | Invoice printing time (guest bill time). | [optional]
**when_closed** | **string** | Delivery closing time (Local for delivery terminal). | [optional]
**conception** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderConception**](IikoTransportPublicApiContractsDeliveriesResponseOrderConception.md) | Concept. | [optional]
**guests_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderGuestsInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderGuestsInfo.md) | Information about order guests. |
**items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItem[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderItem.md) | Order items. |
**combos** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderCombo[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderCombo.md) | Combo. | [optional]
**payments** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentItem[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderPaymentItem.md) | Payments. | [optional]
**tips** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderTipsPaymentItem[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderTipsPaymentItem.md) | Tips. | [optional]
**discounts** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderDiscountItem[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderDiscountItem.md) | Discounts. | [optional]
**order_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderType**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderType.md) | Order type. |
**terminal_group_id** | **string** | ID of the terminal group where the order is located. |
**processed_payments_sum** | **float** | The amount of processed payments.  &lt;remarks&gt;  null - only for unsupported POS versions.  &lt;/remarks&gt;   &gt; Allowed from version &#x60;7.6.0&#x60;. |
**loyalty_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderLoyaltyInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderLoyaltyInfo.md) | Information about Loyalty app.  &lt;remarks&gt;  null - only for unsupported POS versions.  &lt;/remarks&gt; | [optional]
**external_data** | [**\IIKO\Model\IikoTransportPublicApiContractsCommonExternalData[]**](IikoTransportPublicApiContractsCommonExternalData.md) | Order external data.   &gt; Allowed from version &#x60;8.0.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
