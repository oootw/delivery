# DisassembleDocumentCreateRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity |
**amount_unit** | **string** | Unit of measure identifier (GUID) | [optional]
**comment** | **string** | Comment | [optional]
**conception** | **string** | Concept identifier (GUID) | [optional]
**date** | **string** | Document date and time (ISO 8601 YYYY-MM-DDThh:mm:ss.sss±hh:mm) |
**document_id** | **string** |  | [optional]
**items** | [**\IIKO\Model\DisassembleDocumentCreateItem[]**](DisassembleDocumentCreateItem.md) | List of document items |
**number** | **string** | Document number | [optional]
**organization_id** | **string** | Organization identifier (GUID) |
**product** | **string** | Product identifier (GUID) |
**store_from** | **string** | Write-off store identifier (GUID) |
**store_to** | **string** | Receipt store identifier (GUID) |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
