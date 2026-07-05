# IikoTransportPublicApiContractsDeliveriesRequestCreateOrderCombo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Combo ID.  MUST be unique for the whole system. Therefore it must be generated with Guid.NewGuid(). |
**name** | **string** | Name of combo. |
**amount** | **int** | Quantity. |
**price** | **float** | Price of one combo. |
**source_id** | **string** | Combo validity ID. |
**program_id** | **string** | Card program ID.   &gt; Allowed from version &#x60;7.6.1&#x60;. | [optional]
**size_id** | **string** | Size ID. Required if combo has a size scale.   &gt; Allowed from version &#x60;8.5.6&#x60;. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
