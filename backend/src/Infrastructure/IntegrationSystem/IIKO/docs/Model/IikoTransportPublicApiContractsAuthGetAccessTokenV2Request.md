# IikoTransportPublicApiContractsAuthGetAccessTokenV2Request

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**api_key** | **string** | API key generated in iikoWeb under \&quot;Integrations → API Keys\&quot;.   The key determines which restaurant organizations the token grants access to. |
**app_id** | **string** | Unique application identifier issued by the iiko Developer Portal (https://public-api.iikoweb.ru/portal).  You receive it when you register a new application in your developer account.  The &#x60;appId&#x60; never changes for the lifetime of the application. |
**client_secret** | **string** | Application secret key issued by the iiko Developer Portal (https://public-api.iikoweb.ru/portal).  The secret is shown **only once** — right after the application is created.  Store it securely. If the secret is lost or compromised, regenerate it in the Developer Portal; the previous secret will be revoked immediately. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
