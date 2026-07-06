# IikoTransportPublicApiContractsTableOrdersResponseTableOrder

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**table_ids** | **string[]** | Table IDs.                Can be obtained by &#x60;/api/1/reserve/available_restaurant_sections&#x60; operation. |
**customer** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderRegularCustomer**](IikoTransportPublicApiContractsDeliveriesResponseOrderRegularCustomer.md) | Guest.   &gt; Allowed from version &#x60;7.5.2&#x60;. | [optional]
**phone** | **string** | Guest phone.   &gt; Allowed from version &#x60;7.5.2&#x60;. | [optional]
**status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus**](IikoTransportPublicApiContractsDeliveriesResponseOrderOrderStatus.md) | Order status. |
**when_created** | **string** | Order creation date (terminal time zone). | [optional]
**waiter** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee**](IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee.md) | Order waiter. | [optional]
**tab_name** | **string** | Tab name (only for fastfood terminals group in tab mode). | [optional]
**split_order_between_cash_registers** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseSplitOrderBetweenCashRegisters**](IikoTransportPublicApiContractsTableOrdersResponseSplitOrderBetweenCashRegisters.md) | Need to split order between cash registers.  &lt;remarks&gt;  Not empty for orders in statuses New or Bill.  &lt;/remarks&gt; | [optional]
**menu_id** | **string** | External menu ID. | [optional]
**price_category** | [**\IIKO\Model\IikoTransportPublicApiContractsCommonPriceCategory**](IikoTransportPublicApiContractsCommonPriceCategory.md) | Price Category of the order.   &gt; Allowed from version &#x60;9.0.5&#x60;. | [optional]
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
