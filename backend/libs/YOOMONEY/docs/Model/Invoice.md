# Invoice

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Invoice ID in YooMoney. |
**status** | [**\YOOMONEY\Model\InvoiceStatus**](InvoiceStatus.md) |  |
**cart** | [**\YOOMONEY\Model\LineItem[]**](LineItem.md) | Корзина заказа — список товаров или услуг, который отобразится на странице счета перед оплатой. |
**delivery_method** | [**\YOOMONEY\Model\InvoiceDeliveryMethod**](InvoiceDeliveryMethod.md) |  | [optional]
**payment_details** | [**\YOOMONEY\Model\PaymentDetails**](PaymentDetails.md) |  | [optional]
**created_at** | **\DateTime** | Дата и время создания счета на оплату. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2017-11-03T11:52:31.827Z |
**expires_at** | **\DateTime** | Срок действия счета — дата и время, до которых можно оплатить выставленный счет. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: 2024-10-18T10:51:18.139Z Присутствует только для счетов в статусе pending. | [optional]
**description** | **string** | Описание выставленного счета (не более 128 символов), которое вы увидите в личном кабинете ЮKassa, а пользователь на странице счета. Например: «Счет на оплату по договору 37». | [optional]
**cancellation_details** | [**\YOOMONEY\Model\InvoiceCancellationDetails**](InvoiceCancellationDetails.md) |  | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
