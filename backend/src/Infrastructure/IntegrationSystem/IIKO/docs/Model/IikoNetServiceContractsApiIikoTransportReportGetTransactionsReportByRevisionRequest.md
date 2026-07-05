# IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**customer_id** | **string** | Customer id. |
**revision** | **int** | Report since revision. Included if LastTransactionId set.. | [optional]
**last_transaction_id** | **string** | Report since transaction. Excluded. Can&#39;t be used without revision.. | [optional]
**page_size** | **int** | Page size. Ignored if more than max size on server.. |
**organization_id** | **string** | Organization id. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
