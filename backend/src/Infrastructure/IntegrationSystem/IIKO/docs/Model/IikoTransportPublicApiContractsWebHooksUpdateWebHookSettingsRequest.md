# IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**organization_id** | **string** | Organization UOC Id.                Can be obtained by &#x60;/api/1/organizations&#x60; operation. |
**web_hooks_uri** | **string** | Webhook handler url. |
**auth_token** | **string** | Authorization token to pass to the webhook handler. | [optional]
**web_hooks_filter** | [**\IIKO\Model\IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHooksFilter**](IikoTransportPublicApiContractsIntegrationWebHooksFiltersWebHooksFilter.md) | Webhooks filter. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
