# ReceiptDataCustomer

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**full_name** | **string** | Для юрлица — название организации, для ИП и физического лица — ФИО. Если у физлица отсутствует ИНН, в этом же параметре передаются паспортные данные. Не более 256 символов. Можно передавать, если используете Чеки от ЮKassa или онлайн-кассу Orange Data, Атол Онлайн. | [optional]
**inn** | **string** | ИНН пользователя (10 или 12 цифр). Если у физического лица отсутствует ИНН, необходимо передать паспортные данные в параметре full_name. Можно передавать, если используете Чеки от ЮKassa или онлайн-кассу Orange Data, Атол Онлайн. | [optional]
**email** | **string** | User&#39;s email address for sending the receipt. A required parameter if you use Receipts from YooMoney or a third-party online sales register, and if you don&#39;t set the phone parameter. | [optional]
**phone** | **string** | Телефон пользователя для отправки чека. Указывается в формате ITU-T E.164: https://ru.wikipedia.org/wiki/E.164, например 79000000000. Обязательный параметр, если не передан email. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
