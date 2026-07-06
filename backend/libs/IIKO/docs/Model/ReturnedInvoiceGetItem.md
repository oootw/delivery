# ReturnedInvoiceGetItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity | [optional]
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**container_id** | **string** | Container identifier (GUID) | [optional]
**customs_declaration_number** | **string** | Customs declaration number | [optional]
**discount_sum** | **float** | Discount amount | [optional]
**income_price** | **float** |  | [optional]
**num** | **int** | Item sequence number | [optional]
**price** | **float** | Price including VAT. Required if sum is not specified | [optional]
**price_without_vat** | **float** | Price excluding VAT | [optional]
**producer** | **string** | Manufacturer / importer | [optional]
**product** | **string** | Product identifier (GUID) | [optional]
**product_article** | **string** | Nomenclature article | [optional]
**store** | **string** | Store identifier (GUID) | [optional]
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**sum_without_vat** | **float** | Amount excluding VAT | [optional]
**supplier_product** | **string** | Supplier product | [optional]
**vat_percent** | **float** | VAT percentage | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
