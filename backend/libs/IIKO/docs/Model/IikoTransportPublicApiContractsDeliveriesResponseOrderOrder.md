# IikoTransportPublicApiContractsDeliveriesResponseOrderOrder

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**parent_delivery_id** | **string** | ID of delivery serving as source for splitting by FCRs. | [optional]
**customer** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer**](IikoTransportPublicApiContractsDeliveriesResponseOrderCustomer.md) | Delivery customer. | [optional]
**phone** | **string** | Delivery phone number. |
**phone_extension** | **string** | Extension delivery phone number. | [optional]
**delivery_point** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderDeliveryPoint**](IikoTransportPublicApiContractsDeliveriesResponseOrderDeliveryPoint.md) | Delivery point details.  &lt;remarks&gt;  Not required if order type is customer pickup. Otherwise, required.  &lt;/remarks&gt; | [optional]
**status** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus**](IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus.md) | Delivery status.                &gt; Delivery status &#x60;ReadyForCooking&#x60; is deprecated from version &#x60;9.0.6&#x60;. |
**cancel_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelInfo.md) | Delivery cancellation details.  &lt;remarks&gt;  Required only if delivery is canceled, i.e. status&#x3D;Canceled.  &lt;/remarks&gt; | [optional]
**courier_info** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCourierInfo**](IikoTransportPublicApiContractsDeliveriesResponseOrderCourierInfo.md) | Driver information. | [optional]
**complete_before** | **string** | Order fulfillment time (Local for the terminal). |
**when_created** | **string** | Delivery creation time in iikoFront (Local for the terminal). |
**when_confirmed** | **string** | Delivery confirmation time (Local for the terminal). | [optional]
**when_printed** | **string** | Service printing time (Local for the terminal). | [optional]
**when_cooking_completed** | **string** | Cooking completion time (Local for the terminal). | [optional]
**when_sended** | **string** | Delivery dispatch time (Local for the terminal). | [optional]
**when_delivered** | **string** | Actual delivery time (Local for delivery terminal). | [optional]
**comment** | **string** | Order comment. | [optional]
**problem** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderProblem**](IikoTransportPublicApiContractsDeliveriesResponseOrderProblem.md) | Problem flag. | [optional]
**operator** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee**](IikoTransportPublicApiContractsDeliveriesResponseOrderEmployee.md) | Operator that took order. | [optional]
**marketing_source** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Marketing source. | [optional]
**delivery_duration** | **int** | Duration of delivery (in minutes). | [optional]
**index_in_courier_route** | **int** | Ordinal number in route list.  &lt;remarks&gt;  Field is filled up at the time of delivery allocation by logistics in iikoFront.  If logistics is not in use, the field is not filled up.  &lt;/remarks&gt; | [optional]
**cooking_start_time** | **string** | The time when you need to start cooking an order (Local for the terminal). |
**is_deleted** | **bool** | Order is deleted. | [optional]
**when_received_by_api** | **string** | Moment of time when CloudAPI received the request to create the order (UTC). | [optional]
**when_received_from_front** | **string** | Moment of time when the order first received and saved from iikoFront (UTC). | [optional]
**moved_from_delivery_id** | **string** | Tells that this delivery has been moved from terminal group  with id *MovedFromTerminalGroupId* by cancelling delivery with deliveryId *MovedFromDeliveryId*.   &gt; Allowed from version &#x60;7.5.4&#x60;. | [optional]
**moved_from_terminal_group_id** | **string** | Tells that this delivery has been moved from terminal group  with id *MovedFromTerminalGroupId* by cancelling delivery with deliveryId *MovedFromDeliveryId*.   &gt; Allowed from version &#x60;7.5.4&#x60;. | [optional]
**moved_from_organization_id** | **string** | Tells that this delivery has been moved from terminal group  with id *MovedFromTerminalGroupId* by cancelling delivery with deliveryId *MovedFromDeliveryId*.   &gt; Allowed from version &#x60;7.5.4&#x60;. | [optional]
**external_courier_service** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | ECS info.   &gt; Allowed from version &#x60;7.7.7&#x60;. | [optional]
**moved_to_delivery_id** | **string** | Tells that this delivery has been canceled and moved to terminal group  with id *MovedToTerminalGroupId*. | [optional]
**moved_to_terminal_group_id** | **string** |  | [optional]
**moved_to_organization_id** | **string** |  | [optional]
**menu_id** | **string** | External menu ID. | [optional]
**delivery_zone** | **string** | Name of delivery zone. | [optional]
**locked_at** | **string** | Timestamp of when the order was taken for editing (lock). | [optional]
**estimated_time** | **string** | Delivery estimated time. | [optional]
**is_asap** | **bool** | Whether to deliver as soon as possible. | [optional]
**when_packed** | **string** | Delivery packing time (Local for the terminal). | [optional]
**price_category** | [**\IIKO\Model\IikoTransportPublicApiContractsCommonPriceCategory**](IikoTransportPublicApiContractsCommonPriceCategory.md) | Price category of the order.   &gt; Allowed from version &#x60;9.0.5&#x60;. | [optional]
**tracking_link** | **string** | Order&#39;s tracking link. | [optional]
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
