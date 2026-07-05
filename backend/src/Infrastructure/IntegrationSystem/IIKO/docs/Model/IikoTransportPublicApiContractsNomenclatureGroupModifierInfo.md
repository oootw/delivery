# IikoTransportPublicApiContractsNomenclatureGroupModifierInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | ID. |
**min_amount** | **int** | Minimum quantity. |
**max_amount** | **int** | Maximum quantity. |
**required** | **bool** | Required availability. |
**child_modifiers_have_min_max_restrictions** | **bool** | Presence of max/min quantity limitations of child modifiers. | [optional]
**child_modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureChildModifierInfo[]**](IikoTransportPublicApiContractsNomenclatureChildModifierInfo.md) | List of child modifiers. |
**hide_if_default_amount** | **bool** | Hide if the amount is by default. This field is supported since 7.2.4 iikoRMS version. | [optional]
**default_amount** | **int** | Amount by default. This field is supported since 7.2.4 iikoRMS version. | [optional]
**splittable** | **bool** | Modifier can be split. This field is supported since 7.2.4 iikoRMS version. | [optional]
**free_of_charge_amount** | **int** | Free amount. This field is supported since 7.2.4 iikoRMS version. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
