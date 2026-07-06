# BankCardData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**first6** | **string** | Первые 6 цифр номера карты (BIN). При оплате картой, сохраненной в ЮKassa: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/basics и других сервисах, переданный BIN может не соответствовать значениям last4, expiry_year, expiry_month. | [optional]
**last4** | **string** | Последние 4 цифры номера карты. |
**expiry_year** | **string** | Срок действия, год, YYYY. |
**expiry_month** | **string** | Срок действия, месяц, MM. |
**card_type** | [**\YOOMONEY\Model\BankCardType**](BankCardType.md) |  |
**card_product** | [**\YOOMONEY\Model\BankCardProduct**](BankCardProduct.md) |  | [optional]
**issuer_country** | **string** | Код страны, в которой выпущена карта. Передается в формате ISO-3166 alpha-2: https://www.iso.org/obp/ui/#iso:pub:PUB500001:en. Пример: RU. | [optional]
**issuer_name** | **string** | Наименование банка, выпустившего карту. | [optional]
**source** | [**\YOOMONEY\Model\BankCardDataSource**](BankCardDataSource.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
