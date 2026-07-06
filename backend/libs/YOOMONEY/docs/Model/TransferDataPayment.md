# TransferDataPayment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**account_id** | **string** | ID of the store in favor of which you&#39;re accepting the receipt. Provided by YooMoney, displayed in the Sellers: https://yookassa.ru/my/marketplace/sellers section of your Merchant Profile (shopId column). |
**amount** | [**\YOOMONEY\Model\TransferAmount**](TransferAmount.md) |  |
**platform_fee_amount** | [**\YOOMONEY\Model\TransferAmount**](TransferAmount.md) |  | [optional]
**description** | **string** | Transaction description (up to 128 characters), which the seller will see in the YooMoney Merchant Profile. Example: \&quot;Marketplace order No. 72\&quot;. | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
