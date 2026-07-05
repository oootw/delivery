# IikoTransportPublicApiContractsDeliveriesResponseOrderDiscountItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**discount_type** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause**](IikoTransportPublicApiContractsDeliveriesResponseOrderCancelCause.md) | Discount type.                 Can be obtained by &#x60;/api/1/discounts&#x60; operation. |
**sum** | **float** | Total. |
**selective_positions** | **string[]** | Order item positions. | [optional]
**selective_positions_with_sum** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderPositionWithSum[]**](IikoTransportPublicApiContractsDeliveriesResponseOrderPositionWithSum.md) | Order item positions with position discount sum.   &gt; Allowed from version &#x60;8.5.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
