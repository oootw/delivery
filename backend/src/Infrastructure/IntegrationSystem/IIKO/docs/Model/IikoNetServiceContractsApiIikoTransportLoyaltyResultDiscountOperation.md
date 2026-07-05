# IikoNetServiceContractsApiIikoTransportLoyaltyResultDiscountOperation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**code** | [**\IIKO\Model\IikoNetCommonEnumsCounterMetric**](IikoNetCommonEnumsCounterMetric.md) | Operation Type Code.  &lt;br&gt;0 - fixed discount for the entire order,&lt;br /&gt;1 - fixed discount for the item,&lt;br /&gt;2 - free product,&lt;br /&gt;3 - other type of discounts. | [optional]
**order_item_id** | **string** | Deprecated, use positionId. | [optional]
**position_id** | **string** | Id of item the discount is applied to. If null - discount applied to whole orders. | [optional]
**discount_sum** | **float** | Discount sum. | [optional]
**amount** | **float** | Amount. | [optional]
**comment** | **string** | Comment. Can be null. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
