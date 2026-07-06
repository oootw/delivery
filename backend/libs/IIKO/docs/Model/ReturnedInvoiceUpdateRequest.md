# ReturnedInvoiceUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**counteragent** | **string** | Counteragent identifier (GUID) |
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**default_store** | **string** | Default store identifier (GUID) | [optional]
**document_id** | **string** | Document identifier (GUID) |
**expense_account** | **string** | Expense account identifier (GUID) | [optional]
**incoming_invoice_id** | **string** | Associated incoming invoice identifier (GUID) | [optional]
**items** | [**\IIKO\Model\ReturnedInvoiceCreateItem[]**](ReturnedInvoiceCreateItem.md) | List of document items |
**number** | **string** | Document number |
**organization_id** | **string** | Organization identifier (GUID) |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
