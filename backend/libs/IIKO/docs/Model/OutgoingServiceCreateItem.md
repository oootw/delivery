# OutgoingServiceCreateItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | **float** | Product quantity |
**discount_sum** | **float** | Discount amount | [optional]
**num** | **int** | Item sequence number |
**price** | **float** | Price including VAT. Required if sum is not specified | [optional]
**product** | **string** | Product identifier (GUID) |
**revenue_account** | **string** | Revenue account identifier (GUID) |
**split_vat** | **bool** | Split VAT accounting flag | [optional]
**sum** | **float** | Amount including VAT. Required if price is not specified | [optional]
**vat_percent** | **float** | VAT percentage |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
