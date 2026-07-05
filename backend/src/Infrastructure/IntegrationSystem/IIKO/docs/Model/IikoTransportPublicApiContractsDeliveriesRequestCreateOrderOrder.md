# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrder

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Order ID. Must be unique.  &gt; If sent null, it generates automatically on iikoTransport side. | [optional]
**external_number** | **string** | Order external number.   &gt; Allowed from version &#x60;8.0.6&#x60;. | [optional]
**complete_before** | **string** | Order fulfillment date.  &gt; Date and time must be local for delivery terminal, without time zone (take a look at example).   &gt; If null, order is urgent and time is calculated based on customer settings,  &gt; i.e. the shortest delivery time possible.  &gt; Permissible values: from current day and 60 days on. | [optional]
**phone** | **string** | Telephone number.  &gt; Must begin with symbol \&quot;+\&quot; and must be at least 8 digits. |
**phone_extension** | **string** | Extension telephone number.  &gt; Must contain only digits and have length from 1 to 10 symbols.   &gt; Allowed from version &#x60;9.2.5&#x60;. | [optional]
**order_type_id** | **string** | Order type ID.     Can be obtained by &#x60;/api/1/deliveries/order_types&#x60; operation.    &gt; Only one of the fields must be defined: **orderTypeId** or **orderServiceType**. | [optional]
**order_service_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType.md) | Order service type.  &gt; Only one of the fields must be defined: **orderTypeId** or **orderServiceType**.   &gt; Allowed from version &#x60;7.0.3&#x60;. | [optional]
**delivery_point** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryPoint**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDeliveryPoint.md) | Delivery point details.  &gt; Not required in case of customer pickup. Otherwise, required. | [optional]
**comment** | **string** | Order comment. | [optional]
**customer** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCustomer**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCustomer.md) | Customer.                &#39;Regular&#39; customer:    - can be used only if a customer agrees to take part in the store&#39;s loyalty programs  - customer details will be added (updated) to the store&#39;s customer database  - benefits (accumulation of rewards, etc.) of active loyalty programs will be made available to the customer     &#39;One-time&#39; customer:    - should be used if a customer does not agree to take part in the store&#39;s loyalty programs or an aggregator (external system) does not provide customer details  - customer details will NOT be added to the store&#39;s customer database and will be used ONLY to complete the current order | [optional]
**guests** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderGuests**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderGuests.md) | Guest details. Not equal to the customer who makes an order. | [optional]
**marketing_source_id** | **string** | Marketing source (advertisement) ID.                 Can be obtained by &#x60;/api/1/marketing_sources&#x60; operation. | [optional]
**operator_id** | **string** | Operator ID.   &gt; Allowed from version &#x60;7.6.3&#x60;. | [optional]
**delivery_duration** | **int** | Delivery duration.   &gt; Allowed from version &#x60;8.8.6&#x60;. | [optional]
**delivery_zone** | **string** | Name of delivery zone.   &gt; Allowed from version &#x60;8.8.6&#x60;. | [optional]
**price_category_id** | **string** | Price category id of the order.    Can be obtained by &#x60;/api/2/menu&#x60; operation.   &gt; Allowed from version &#x60;9.0.5&#x60;. | [optional]
**items** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderItem.md) | Order items. |
**combos** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo.md) | Combos included in order. | [optional]
**payments** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderPayment.md) | Order payment components.   &gt; Type **LoyaltyCard** allowed from version &#x60;7.1.5&#x60;. | [optional]
**tips** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderTipsPayment.md) | Order tips components. | [optional]
**source_key** | **string** | The string key (marker) of the source (partner - api user) that created the order. Needed to limit the visibility of orders for external integration. | [optional]
**discounts_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderDiscountsInfo.md) | Discounts/surcharges. | [optional]
**loyalty_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderLoyaltyInfo.md) | Information about Loyalty app. | [optional]
**cheque_additional_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo**](IikoTransportPublicApiContractsDeliveriesCommonChequeAdditionalInfo.md) | Cheque additional information. | [optional]
**external_data** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData[]**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderExternalData.md) | Order external data.   &gt; Allowed from version &#x60;8.0.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
