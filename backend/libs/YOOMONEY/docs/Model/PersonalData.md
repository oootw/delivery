# PersonalData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор персональных данных, сохраненных в ЮKassa. |
**type** | [**\YOOMONEY\Model\PersonalDataType**](PersonalDataType.md) |  |
**status** | **string** | Статус персональных данных. Возможные значения: waiting_for_operation — данные сохранены, но не использованы при проведении выплаты; active — данные сохранены и использованы при проведении выплаты; данные можно использовать повторно до срока, указанного в параметре expires_at; canceled — хранение данных отменено, данные удалены, инициатор и причина отмены указаны в объекте cancellation_details (финальный и неизменяемый статус). Жизненный цикл персональных данных зависит от назначения данных: передача данных получателя выплаты: https://yookassa.ru/developers/payouts/scenario-extensions/recipient-data-send#lifecircle для выписки из реестра или проверка получателя: https://yookassa.ru/developers/payouts/scenario-extensions/recipient-check#lifecircle при выплатах через СБП. |
**cancellation_details** | [**\YOOMONEY\Model\PersonalDataCancellationDetails**](PersonalDataCancellationDetails.md) |  | [optional]
**created_at** | **\DateTime** | Время создания персональных данных. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z |
**expires_at** | **\DateTime** | Срок жизни объекта персональных данных — время, до которого вы можете использовать персональные данные при проведении операций. Указывается только для объекта в статусе active. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
