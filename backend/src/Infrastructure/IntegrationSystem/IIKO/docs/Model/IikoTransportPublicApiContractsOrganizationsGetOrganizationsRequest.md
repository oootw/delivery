# IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_ids** | **string[]** | Organizations IDs which have to be returned. By default - all organizations from apiLogin.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. | [optional]
**return_additional_info** | **bool** | A sign whether additional information about the organization should be returned (RMS version, country, restaurantAddress, etc.),    or only minimal information should be returned (id and name). | [optional]
**include_disabled** | **bool** | Attribute that shows that response contains disabled organizations. | [optional]
**return_external_data** | **string[]** | External data keys that have to be returned. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
