# IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_ids** | **string[]** | Organization ID for which an order search will be performed.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**terminal_group_ids** | **string[]** | List of terminal groups IDs. | [optional]
**delivery_date_from** | **string** | Order delivery date (Local for delivery terminal). Lower limit.                The guaranteed order availability period is the last 7 days. To access earlier orders, use the &#x60;/api/1/deliveries/history/by_delivery_date_and_phone&#x60; method. | [optional]
**delivery_date_to** | **string** | Order delivery date (Local for delivery terminal). Upper limit. | [optional]
**statuses** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus[]**](IikoTransportPublicApiContractsDeliveriesCommonDeliveryStatus.md) | Allowed order statuses. | [optional]
**has_problem** | **bool** | If true, delivery has a problem.  &gt; Conditions under which the order has a problem:  &gt; * order.problem.hasProblem is true;  &gt; * order status is Unconfirmed and CookingStartTime before now;  &gt; * order status is ReadyForCooking and (CookingStartTime + timeToCookingErrorTimeout) before now;  &gt; * order status is CookingCompleted or Waiting and (CookingStartTime + cookingTimeout) before now. | [optional]
**order_service_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType**](IikoTransportPublicApiContractsDeliveriesRequestCreateOrderOrderServiceType.md) | Order service type. | [optional]
**search_text** | **string** | Value for search. Used for prefix search. | [optional]
**time_to_cooking_error_timeout** | **int** | Error timeout for status time to cooking, in seconds. | [optional]
**cooking_timeout** | **int** | Expected cooking time, in seconds. | [optional]
**sort_property** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrderSortProperty**](IikoTransportPublicApiContractsDeliveriesRequestOrderSortProperty.md) | Sorting property. | [optional]
**sort_direction** | [**\IIKO\Model\IikoTransportPublicApiContractsCommonSortDirection**](IikoTransportPublicApiContractsCommonSortDirection.md) | Sorting direction. | [optional]
**rows_count** | **int** | Maximum number of items returned. | [optional]
**source_keys** | **string[]** | Source keys. | [optional]
**order_ids** | **string[]** | Order IDs.                &gt; Must be null if \&quot;posOrderIds\&quot; is not null. | [optional]
**pos_order_ids** | **string[]** | POS order IDs.                &gt; Must be null if \&quot;orderIds\&quot; is not null. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
