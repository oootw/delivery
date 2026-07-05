# OutgoingInvoiceItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity | [optional]
**amount_factor** | **float** | Write-off factor | [optional]
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**container_id** | **string** | Container identifier (GUID) | [optional]
**discount_sum** | **float** | Discount amount | [optional]
**num** | **int** | Item sequence number | [optional]
**price** | **float** | Price including VAT. Required if sum is not specified | [optional]
**price_without_vat** | **float** | Price excluding VAT | [optional]
**product** | **string** | Product identifier (GUID) | [optional]
**product_article** | **string** | Nomenclature article | [optional]
**product_size** | **string** | Product size identifier (GUID) | [optional]
**store** | **string** | Store identifier (GUID) | [optional]
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**sum_without_vat** | **float** | Amount excluding VAT | [optional]
**vat_percent** | **float** | VAT percentage | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
