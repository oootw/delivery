# ComboDto2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**name** | **string** | Combo name |
**price** | **float** | Combo price, if price strategy is fixed | [optional]
**groups** | [**\IIKO\Model\ComboGroupDto2[]**](ComboGroupDto2.md) |  | [optional]
**image** | [**\IIKO\Model\ComboDto2ImageInner[]**](ComboDto2ImageInner.md) | Combo image |
**description** | **string** | Combo description | [optional] [default to '']
**sizes** | [**\IIKO\Model\ComboSizeDto2[]**](ComboSizeDto2.md) | Available sizes for combo (can be empty) | [optional]
**price_strategy** | [**Enum**](Enum.md) |  |
**start_date** | **string** | The date when the combo will be available until |
**expiration_date** | **string** | The date when the combo will be available until |
**id** | **string** | Combo id |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
