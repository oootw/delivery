# SalesDocumentCreateItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity |
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**container_id** | **string** | Container identifier (GUID) | [optional]
**discount_sum** | **float** | Discount amount | [optional]
**num** | **int** | Item sequence number |
**price** | **float** | Price including VAT. Required if sum is not specified | [optional]
**product** | **string** | Product identifier (GUID) |
**product_size** | **string** | Product size identifier (GUID) | [optional]
**store** | **string** | Store identifier (GUID) | [optional]
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**vat_percent** | **float** | VAT percentage | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
