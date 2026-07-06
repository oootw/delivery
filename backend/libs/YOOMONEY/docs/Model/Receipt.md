# Receipt

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор чека в ЮKassa. |
**type** | [**\YOOMONEY\Model\ReceiptType**](ReceiptType.md) |  |
**payment_id** | **string** | Идентификатор платежа: https://yookassa.ru/developers/api#payment_object, для которого был сформирован чек. | [optional]
**refund_id** | **string** | Идентификатор возврата: https://yookassa.ru/developers/api#refund_object, для которого был сформирован чек. Отсутствует в чеке платежа. | [optional]
**status** | [**\YOOMONEY\Model\ReceiptRegistrationStatus**](ReceiptRegistrationStatus.md) | Статус доставки данных для чека в онлайн-кассу. Возможные значения: pending — данные в обработке; succeeded — чек успешно зарегистрирован; canceled — чек зарегистрировать не удалось; если используете Чеки от ЮKassa: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/basics, обратитесь в техническую поддержку, в остальных случаях сформируйте чек вручную. |
**fiscal_document_number** | **string** | Номер фискального документа. | [optional]
**fiscal_storage_number** | **string** | Номер фискального накопителя в кассовом аппарате. | [optional]
**fiscal_attribute** | **string** | Фискальный признак чека. Формируется фискальным накопителем на основе данных, переданных для регистрации чека. | [optional]
**registered_at** | **\DateTime** | Дата и время формирования чека в фискальном накопителе. Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. | [optional]
**fiscal_provider_id** | **string** | Идентификатор чека в онлайн-кассе. Присутствует, если чек удалось зарегистрировать. | [optional]
**items** | [**\YOOMONEY\Model\ReceiptItem[]**](ReceiptItem.md) | List of products in the receipt: no more than 80 items for Receipts from YooMoney: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/basics, no more than 100 items for third-party online sales registers: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/basics. |
**internet** | **bool** | Признак проведения платежа в интернете (тег в 54 ФЗ — 1125) — указывает на оплату через интернет. Возможные значения: true — оплата прошла онлайн, через интернет (например, на вашем сайте или в приложении); false — оплата прошла офлайн, при личном взаимодействии (например, в торговой точке или при встрече с курьером). По умолчанию true. Если вы принимаете платежи офлайн, передайте в запросе значение false. | [optional]
**settlements** | [**\YOOMONEY\Model\Settlement[]**](Settlement.md) | Перечень совершенных расчетов. | [optional]
**on_behalf_of** | **string** | Идентификатор магазина, от имени которого нужно отправить чек. Выдается ЮKassa. Присутствует, если вы используете Сплитование платежей: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. | [optional]
**tax_system_code** | **int** | Система налогообложения магазина (тег в 54 ФЗ — 1055). Для сторонних онлайн-касс: обязательный параметр, если вы используете онлайн-кассу Атол Онлайн, обновленную до ФФД 1.2, или у вас несколько систем налогообложения, в остальных случаях не передается. Перечень возможных значений: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/parameters-values#tax-systems Для Чеков от ЮKassa: параметр передавать не нужно, ЮKassa его проигнорирует. | [optional]
**timezone** | **int** | Номер часовой зоны для адреса, по которому вы принимаете платежи (тег в 54 ФЗ — 1011). Указывается, только если в чеке есть товары, которые подлежат обязательной маркировке (в items.mark_code_info передается параметр gs_1m, short или fur). Перечень возможных значений: для Чеков от ЮKassa: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/parameters-values#timezone; для сторонних онлайн-касс: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/parameters-values#timezone. | [optional]
**receipt_industry_details** | [**\YOOMONEY\Model\IndustryDetails[]**](IndustryDetails.md) | Отраслевой реквизит предмета расчета (тег в 54 ФЗ — 1260). | [optional]
**receipt_operational_details** | [**\YOOMONEY\Model\OperationalDetails**](OperationalDetails.md) | Операционный реквизит чека (тег в 54 ФЗ — 1270). | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
