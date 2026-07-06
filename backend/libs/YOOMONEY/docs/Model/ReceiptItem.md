# ReceiptItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**description** | **string** | Название товара (не более 128 символов). Тег в 54 ФЗ — 1030). |
**quantity** | **float** | Количество товара (тег в 54 ФЗ — 1023). Формат: десятичное число, дробная часть — три знака или больше (количество знаков зависит от quantity в запросе). Разделитель дробной части — точка, разделитель тысяч отсутствует. Пример: 5.000 |
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Цена товара (тег в 54 ФЗ — 1079). |
**vat_code** | **int** | Ставка НДС (тег в 54 ФЗ — 1199). Перечень возможных значений: * для Чеков от ЮKassa: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/parameters-values#vat-codes * для сторонних онлайн-касс: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/parameters-values#vat-codes |
**payment_subject** | [**\YOOMONEY\Model\ReceiptItemPaymentSubject**](ReceiptItemPaymentSubject.md) |  | [optional]
**payment_mode** | [**\YOOMONEY\Model\ReceiptItemPaymentMode**](ReceiptItemPaymentMode.md) |  | [optional]
**country_of_origin_code** | **string** | Код страны происхождения товара по общероссийскому классификатору стран мира (OК (MК (ИСО 3166) 004-97) 025-2001: http://docs.cntd.ru/document/842501280). Тег в 54 ФЗ — 1230. Пример: RU. Онлайн-кассы, которые поддерживают этот параметр: Orange Data, Кит Инвест. | [optional]
**customs_declaration_number** | **string** | Номер таможенной декларации (от 1 до 32 символов). Тег в 54 ФЗ — 1231. Онлайн-кассы, которые поддерживают этот параметр: Orange Data, Кит Инвест. | [optional]
**excise** | **string** | Сумма акциза товара с учетом копеек (тег в 54 ФЗ — 1229). Десятичное число с точностью до 2 символов после точки. Онлайн-кассы, которые поддерживают этот параметр: Orange Data, Кит Инвест. | [optional]
**supplier** | [**\YOOMONEY\Model\ReceiptItemSupplierWithInn**](ReceiptItemSupplierWithInn.md) |  | [optional]
**agent_type** | [**\YOOMONEY\Model\ReceiptItemAgentType**](ReceiptItemAgentType.md) |  | [optional]
**mark_code_info** | [**\YOOMONEY\Model\MarkCodeInfo**](MarkCodeInfo.md) |  | [optional]
**measure** | [**\YOOMONEY\Model\ReceiptItemMeasure**](ReceiptItemMeasure.md) |  | [optional]
**payment_subject_industry_details** | [**\YOOMONEY\Model\IndustryDetails[]**](IndustryDetails.md) | Отраслевой реквизит предмета расчета (тег в 54 ФЗ — 1260). Обязателен при использовании ФФД 1.2. | [optional]
**product_code** | **string** | Product code (tag 1162 in 54-FZ) is a unique number assigned to a unit of product during marking process. Format: hexadecimal number with spaces. Maximum length is 32 bytes. Example: 00 00 00 01 00 21 FA 41 00 23 05 41 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 12 00 AB 00. This parameter is required if both conditions apply: your online sales register is updated to FFD 1.05 or 1.1; the product is subject to mandatory marking: http://docs.cntd.ru/document/902192509. The parameter must not be included in the request if you are using Receipts from YooMoney: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/basics or an online sales register updated to FFD 1.2: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/marking. | [optional]
**planned_status** | **int** | Planned product status. Tag in 54-FZ: 2003. To be specified only for products that are subject to mandatory marking (parameter gs_1m, short, or fur is set in items.mark_code_info). Possible values are: for Receipts from YooMoney: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/parameters-values#planned-status; for third party online sales registers: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/parameters-values#planned-status. | [optional]
**mark_mode** | **string** | Режим обработки кода маркировки (тег в 54 ФЗ — 2102). Обязательный параметр, если одновременно выполняются эти условия: * вы используете Чеки от ЮKassa или онлайн-кассу Атол Онлайн или BusinessRu, обновленную до ФФД 1.2; * товар нужно маркировать: http://docs.cntd.ru/document/902192509. Должен принимать значение равное «0». | [optional]
**mark_quantity** | [**\YOOMONEY\Model\MarkQuantity**](MarkQuantity.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
