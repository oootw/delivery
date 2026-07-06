# IncomingInvoiceRequestItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**actual_amount** | **float** | Actual quantity | [optional]
**amount** | **float** | Product quantity |
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**container_id** | **string** | Container identifier (GUID) | [optional]
**customs_declaration_number** | **string** | Customs declaration number | [optional]
**is_additional_expense** | **bool** | Is additional expense | [optional]
**num** | **int** | Item sequence number |
**price** | **float** | Price including VAT. Required if sum is not specified | [optional]
**product** | **string** | Product identifier (GUID) |
**store** | **string** | Store identifier (GUID) |
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**supplier_product** | **string** | Supplier product | [optional]
**vat_percent** | **float** | VAT percentage | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
