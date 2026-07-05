# IikoTransportPublicApiContractsNomenclatureNomenclatureResponse

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**correlation_id** | **string** | Operation ID. |
**groups** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureProductsGroupInfo[]**](IikoTransportPublicApiContractsNomenclatureProductsGroupInfo.md) | Stock list group. |
**product_categories** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureProductCategoryInfo[]**](IikoTransportPublicApiContractsNomenclatureProductCategoryInfo.md) | Menu item category. |
**products** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureProductInfo[]**](IikoTransportPublicApiContractsNomenclatureProductInfo.md) | Menu items and modifiers. |
**sizes** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureSize[]**](IikoTransportPublicApiContractsNomenclatureSize.md) | Item sizes. |
**revision** | **int** | The revison (version) of the menu recevied in the response of the request.  This value should be saved by the integration and passed in the &#x60;startRevision&#x60; field  of the next menu request. If the values in &#x60;revision&#x60; and &#x60;startRevision&#x60; are the same,  it means there have been no changes to the menu since the previous request.  In this case, the &#x60;groups&#x60;, &#x60;productCategories&#x60;, &#x60;products&#x60; and &#x60;sizes&#x60; fields  will not contain any data. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
