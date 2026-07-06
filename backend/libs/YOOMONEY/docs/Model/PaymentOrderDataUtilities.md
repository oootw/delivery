# PaymentOrderDataUtilities

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма платежного поручения — сумма, которую пользователь переводит получателю платежа. Равна общей сумме платежа. |
**payment_purpose** | **string** | Payment purpose (no more than 210 characters). The payment purpose should be specified according to the recommendations from Letter of the Bank of Russia No. IN-04-45|12 dated 22.02.2018: https://my.dom.gosuslugi.ru/filestore/publicDownloadServlet?context&#x3D;contentmanagement&amp;uid&#x3D;ef9a477a-2beb-4212-be30-aed231160db1&amp;mode&#x3D;view. Example: Payment for housing and utilities;ELS (Single Personal Account) 80KX478547;PRD (Payment Period) 12.2024;Ivanov Ivan;Moscow, 1 Flotskaya ulitsa, apartment 1 |
**recipient** | [**\YOOMONEY\Model\PaymentOrderRecipientUtilities**](PaymentOrderRecipientUtilities.md) | Получатель платежа — государственная или коммерческая организация, которая предоставляет услуги или является информационным посредником, который собирает и обрабатывает начисления от других поставщиков услуг. |
**kbk** | **string** | Код бюджетной классификации (КБК). | [optional]
**oktmo** | **string** | Код ОКТМО (Общероссийский классификатор территорий муниципальных образований). | [optional]
**payment_period** | [**\YOOMONEY\Model\PaymentPeriod**](PaymentPeriod.md) |  | [optional]
**payment_document_id** | **string** | Идентификатор платежного документа. Обязательный параметр, если не передан payment_document_number, account_number, unified_account_number или service_id. | [optional]
**payment_document_number** | **string** | Номер платежного документа на стороне поставщика ЖКУ. Обязательный параметр, если не передан payment_document_id, account_number, unified_account_number или service_id. | [optional]
**account_number** | **string** | Номер лицевого счета на стороне поставщика ЖКУ. Обязательный параметр, если не передан payment_document_id, payment_document_number, unified_account_number или service_id. | [optional]
**unified_account_number** | **string** | Единый лицевой счет. Уникальный идентификатор в ГИС ЖКХ, который характеризует связку «собственник-помещение». Обязательный параметр, если не передан payment_document_id, payment_document_number, account_number или service_id. | [optional]
**service_id** | **string** | Идентификатор жилищно-коммунальной услуги (ЖКУ). Обязательный параметр, если не передан payment_document_id, payment_document_number, account_number или unified_account_number. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
