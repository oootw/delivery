# SafeDeal

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор сделки. |
**fee_moment** | [**\YOOMONEY\Model\FeeMoment**](FeeMoment.md) |  |
**description** | **string** | Описание сделки (не более 128 символов). Используется для фильтрации при получении списка сделок: https://yookassa.ru/developers/api#get_deals_list. | [optional]
**balance** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Баланс сделки. |
**payout_balance** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма вознаграждения продавца. |
**status** | [**\YOOMONEY\Model\DealStatus**](DealStatus.md) |  |
**created_at** | **\DateTime** | Время создания сделки. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z |
**expires_at** | **\DateTime** | Время автоматического закрытия сделки. Если в указанное время сделка всё еще в статусе opened, ЮKassa вернет деньги покупателю и закроет сделку. По умолчанию время жизни сделки составляет 90 дней. Время указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z |
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**test** | **bool** | Признак тестовой операции. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
