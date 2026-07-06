# CreatePaymentRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Payment amount. Sometimes YooMoney&#39;s partners charge additional commission from the users that is not included in this amount. The amount is specified with the currency code. It should match the currency of your subaccount (recipient.gateway_id) if you separate payment flows, or the currency of the account (shopId in the Merchant Profile) if you don&#39;t. |
**description** | **string** | Описание транзакции (не более 128 символов), которое вы увидите в личном кабинете ЮKassa, а пользователь — при оплате. Например: «Оплата заказа № 72 для user@yoomoney.ru». | [optional]
**receipt** | [**\YOOMONEY\Model\ReceiptData**](ReceiptData.md) |  | [optional]
**recipient** | [**\YOOMONEY\Model\Recipient**](Recipient.md) |  | [optional]
**payment_token** | **string** | One-time payment token generated with Checkout.js: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/checkout-js/basics or mobile SDK: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/mobile-sdks/basics. | [optional]
**payment_method_id** | **string** | Saved payment method: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/basics&#39;s ID. | [optional]
**payment_method_data** | [**\YOOMONEY\Model\CreatePaymentRequestPaymentMethodData**](CreatePaymentRequestPaymentMethodData.md) |  | [optional]
**confirmation** | [**\YOOMONEY\Model\CreatePaymentRequestConfirmation**](CreatePaymentRequestConfirmation.md) |  | [optional]
**save_payment_method** | **bool** | Сохранение платежных данных для проведения автоплатежей: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/basics. Возможные значения: * true — сохранить способ оплаты (сохранить платежные данные); * false — провести платеж без сохранения способа оплаты. Доступно только после согласования с менеджером ЮKassa. | [optional] [default to false]
**capture** | **bool** | Автоматический прием: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-true поступившего платежа. Возможные значения: * true — оплата списывается сразу (платеж в одну стадию); * false — оплата холдируется и списывается по вашему запросу (платеж в две стадии: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel). По умолчанию false. | [optional] [default to false]
**client_ip** | **string** | IPv4 или IPv6-адрес пользователя. Если не указан, используется IP-адрес TCP-подключения. | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**airline** | [**\YOOMONEY\Model\Airline**](Airline.md) | Object containing the data for selling airline tickets. Used only for bank card payments. | [optional]
**transfers** | [**\YOOMONEY\Model\TransferDataPayment[]**](TransferDataPayment.md) | Information about money distribution: the amounts of transfers and the stores to be transferred to. Specified if you use Split payments: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. | [optional]
**deal** | [**\YOOMONEY\Model\PaymentDealInfo**](PaymentDealInfo.md) | The deal within which the payment is being carried out. Specified if you use Safe deal: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics. | [optional]
**merchant_customer_id** | **string** | The identifier of the customer in your system, such as email address or phone number. No more than 200 characters. Specified if you want to save a bank card and offer it for a recurring payment in the YooMoney payment widget: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/widget/basics. | [optional]
**payment_order** | [**\YOOMONEY\Model\PaymentOrderDataUtilities**](PaymentOrderDataUtilities.md) |  | [optional]
**receiver** | [**\YOOMONEY\Model\CreatePaymentRequestReceiver**](CreatePaymentRequestReceiver.md) |  | [optional]
**statements** | [**\YOOMONEY\Model\CreatePaymentRequestStatementsInner[]**](CreatePaymentRequestStatementsInner.md) | Data for sending statements. Required if you want the user to receive a statement after they make a payment. Only one type of statement is currently available: payment overview.  This is the information about a successful payment that YooMoney sends to the user&#39;s email address. An overview may be sent if the payment was made via bank cards, SberPay, or FPS. The option to send overviews is available for all integration scenarios: https://yookassa.ru/developers/payment-acceptance/getting-started/selecting-integration-scenario. | [optional]
**pos_link** | [**\YOOMONEY\Model\PosLinkPaymentData**](PosLinkPaymentData.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
