# Payout

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор выплаты. |
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма выплаты. |
**status** | [**\YOOMONEY\Model\PayoutStatus**](PayoutStatus.md) |  |
**payout_destination** | [**\YOOMONEY\Model\PayoutPayoutDestination**](PayoutPayoutDestination.md) |  |
**description** | **string** | Описание транзакции (не более 128 символов). Например: «Выплата по договору 37». | [optional]
**created_at** | **\DateTime** | Время создания выплаты. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z |
**succeeded_at** | **\DateTime** | Time of a successful payout processing. Based on UTC: https://en.wikipedia.org/wiki/Coordinated_Universal_Time and specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: 2017-11-03T11:52:42.312Z Mandatory parameter for payouts with the succeeded status. | [optional]
**deal** | [**\YOOMONEY\Model\PayoutDeal**](PayoutDeal.md) |  | [optional]
**self_employed** | [**\YOOMONEY\Model\PayoutSelfEmployed**](PayoutSelfEmployed.md) |  | [optional]
**receipt** | [**\YOOMONEY\Model\IncomeReceipt**](IncomeReceipt.md) |  | [optional]
**cancellation_details** | [**\YOOMONEY\Model\PayoutCancellationDetails**](PayoutCancellationDetails.md) |  | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**test** | **bool** | Признак тестовой операции. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
