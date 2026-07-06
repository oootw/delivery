# PaymentData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Payment amount. It must be within limits: https://yookassa.ru/docs/support/payments/limits. The amount is specified with the currency code. It should match the currency of your subaccount (recipient.gateway_id) if you separate payment flows, or the currency of the account (shopId in the Merchant Profile) if you don&#39;t. |
**receipt** | [**\YOOMONEY\Model\ReceiptData**](ReceiptData.md) |  | [optional]
**recipient** | [**\YOOMONEY\Model\Recipient**](Recipient.md) |  | [optional]
**save_payment_method** | **bool** | Сохранение платежных данных для проведения автоплатежей: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/basics. Возможные значения: * true — сохранить способ оплаты (сохранить платежные данные); * false — провести платеж без сохранения способа оплаты. Доступно только после согласования с менеджером ЮKassa. | [optional] [default to false]
**capture** | **bool** | Автоматический прием: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-true поступившего платежа. Возможные значения: * true — оплата списывается сразу (платеж в одну стадию); * false — оплата холдируется и списывается по вашему запросу (платеж в две стадии: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel). По умолчанию false. | [optional] [default to false]
**client_ip** | **string** | IPv4 или IPv6-адрес пользователя. Если не указан, используется IP-адрес TCP-подключения. | [optional]
**description** | **string** | Описание транзакции (не более 128 символов), которое вы увидите в личном кабинете ЮKassa, а пользователь — при оплате. Например: «Оплата заказа № 72 для user@yoomoney.ru». | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
