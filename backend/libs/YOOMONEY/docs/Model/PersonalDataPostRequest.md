# PersonalDataPostRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\PersonalDataType**](PersonalDataType.md) |  |
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**last_name** | **string** | Фамилия пользователя. |
**first_name** | **string** | Имя пользователя. |
**middle_name** | **string** | Отчество пользователя. Обязательный параметр, если есть в паспорте. | [optional]
**birthdate** | **\DateTime** | Дата рождения. Передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
