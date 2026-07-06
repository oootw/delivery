# SafeDealRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\DealType**](DealType.md) |  |
**fee_moment** | [**\YOOMONEY\Model\FeeMoment**](FeeMoment.md) |  |
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**description** | **string** | Описание сделки (не более 128 символов). Используется для фильтрации при получении списка сделок: https://yookassa.ru/developers/api#get_deals_list. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
