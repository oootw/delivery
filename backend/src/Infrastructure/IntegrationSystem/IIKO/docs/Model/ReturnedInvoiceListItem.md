# ReturnedInvoiceListItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**assigned_stores** | **string[]** | Write-off locations (UUID array) | [optional]
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_created** | **string** | Document creation date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**date_modified** | **string** | Document last modification date (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) | [optional]
**deleted** | **bool** | Flag indicating that the document is deleted | [optional]
**document_id** | **string** | Document identifier (GUID) | [optional]
**expense_account** | **string** | Expense account identifier (GUID) | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**number** | **string** | Document number | [optional]
**processed** | **bool** | Flag indicating that the document is processed | [optional]
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**sum_without_vat** | **float** | Amount excluding VAT | [optional]
**user_created** | **string** | User who created the document (GUID) | [optional]
**user_modified** | **string** | User who last modified the document (GUID) | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
