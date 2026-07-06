# IikoTransportPublicApiContractsNomenclatureNomenclatureRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization ID.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**start_revision** | **int** | The revision (version) of the menu saved on the integration side.  Use &#x60;0&#x60; for the first request for each organization. In every subsequent request,  the &#x60;startRevision&#x60; field should contain the value of the &#x60;revision&#x60; field received  in the response to the previous request. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
