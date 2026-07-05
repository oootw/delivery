# IikoTransportPublicApiContractsDiscountsDiscountCardTypeInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Discount ID in RMS. |
**name** | **string** | Discount name. |
**percent** | **float** | Total discount rate.  &gt; Ignored if \&quot;isCategorisedDiscount\&quot; specified. |
**is_categorised_discount** | **bool** | Whether it is category discount or not.  &gt; If true, \&quot;productCategoryDiscounts\&quot; discounts will apply. |
**product_category_discounts** | [**\IIKO\Model\IikoTransportPublicApiContractsDiscountsProductCategoryDiscount[]**](IikoTransportPublicApiContractsDiscountsProductCategoryDiscount.md) | Category discount. |
**comment** | **string** | Comment. | [optional]
**can_be_applied_selectively** | **bool** | Whether discount allows for selected application to individual items at user&#39;s discretion. |
**min_order_sum** | **float** | Minimum order amount required for discount application.  If order amount is less than specified threshold, discount does not apply. | [optional]
**mode** | [**\IIKO\Model\IikoTransportPublicApiContractsDiscountsDiscountCardMode**](IikoTransportPublicApiContractsDiscountsDiscountCardMode.md) | Discount type.     Can be obtained by &#x60;/api/1/discounts&#x60; operation. |
**sum** | **float** | Fixed amount.  &gt; Triggers if fixed amount has been specified. |
**can_apply_by_card_number** | **bool** | Can be applied by card No.  &gt; If true, it&#39;s enough to enter discount card No. (card swiping not required) |
**is_manual** | **bool** | Created manually. |
**is_card** | **bool** | Executed by card. |
**is_automatic** | **bool** | Created automatically. |
**is_deleted** | **bool** | IsDeleted. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
