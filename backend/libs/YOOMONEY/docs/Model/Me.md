# Me

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**account_id** | **string** | Идентификатор магазина или шлюза. |
**status** | **string** | Статус магазина или шлюза. Возможные значения: * enabled — подключен к ЮKassa, может проводить платежи или выплаты; * disabled — не может проводить платежи или выплаты (еще не подключен, закрыт или временно не работает). |
**test** | **bool** | Это тестовый магазин или шлюз. |
**fiscalization** | [**\YOOMONEY\Model\FiscalizationData**](FiscalizationData.md) |  | [optional]
**fiscalization_enabled** | **bool** | Устаревший параметр, который раньше использовался для определения настроек отправки чеков в налоговую. Сохранен для поддержки обратной совместимости, в новых версиях API может быть удален. Используйте объект fiscalization, чтобы определить, какие у магазина настройки отправки чеков. | [optional]
**payment_methods** | [**\YOOMONEY\Model\PaymentMethodType[]**](PaymentMethodType.md) | Список способов оплаты: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-methods#all, доступных магазину. Присутствует, если вы запрашивали настройки магазина. | [optional]
**itn** | **string** | ИНН магазина (от 1 до 20 цифр). Присутствует, если вы запрашивали настройки магазина. | [optional]
**payout_methods** | [**\YOOMONEY\Model\PayoutMethodType[]**](PayoutMethodType.md) | Список способов получения выплат, доступных шлюзу. Возможные значения: * bank_card — выплаты на банковские карты; * yoo_money — выплаты на кошельки ЮMoney; * sbp — выплаты через СБП. Присутствует, если вы запрашивали настройки шлюза. | [optional]
**name** | **string** | Название шлюза, которое отображается в личном кабинете ЮKassa. Присутствует, если вы запрашивали настройки шлюза. | [optional]
**payout_balance** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Баланс вашего шлюза. Присутствует, если вы запрашивали настройки шлюза. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
