# IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_ids** | **string[]** | List of organizations for drivers coordinates of which will be retrieved. |
**offset_in_seconds** | **int** | Interval in seconds from current server time.   If driver coordinates were recorded in server storage   within interval: (\&quot;current server time\&quot; - *OffsetInSeconds*, \&quot;current server time\&quot;],  driver and their coordinates will be retrieved. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
