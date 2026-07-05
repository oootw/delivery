# WriteoffDocumentUpdateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**document_id** | **string** | Document identifier (GUID) |
**expense_account** | **string** | Expense account identifier (GUID) |
**is_automatic** | **bool** | Automatic document creation flag | [optional]
**is_editable** | **bool** | Editable flag. true — available for editing in RMS | [optional]
**items** | [**\IIKO\Model\ProductionDocumentCreateItem[]**](ProductionDocumentCreateItem.md) | List of document items |
**number** | **string** | Document number |
**organization_id** | **string** | Organization identifier (GUID) |
**store_from** | **string** | Write-off store identifier (GUID) |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
