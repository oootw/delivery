# IikoTransportPublicApiContractsNomenclatureProductInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**fat_amount** | **float** | Fat per 100g. | [optional]
**proteins_amount** | **float** | Protein per 100g. | [optional]
**carbohydrates_amount** | **float** | Carbohydrate per 100g. | [optional]
**energy_amount** | **float** | Calories per 100g. | [optional]
**fat_full_amount** | **float** | Fat per item. | [optional]
**proteins_full_amount** | **float** | Protein per item. | [optional]
**carbohydrates_full_amount** | **float** | Carbohydrate per item. | [optional]
**energy_full_amount** | **float** | Calories per item. | [optional]
**weight** | **float** | Item weight. | [optional]
**group_id** | **string** | Stock list group in RMS. | [optional]
**product_category_id** | **string** | Product category in RMS. | [optional]
**type** | **string** | dish | good | modifier. | [optional]
**order_item_type** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureOrderItemType**](IikoTransportPublicApiContractsNomenclatureOrderItemType.md) | Product or compound. Depends on modifiers scheme existence. | [optional]
**modifier_schema_id** | **string** | Modifier schema&#39;s ID. | [optional]
**modifier_schema_name** | **string** | Modifier schema&#39;s name. | [optional]
**splittable** | **bool** | Is product splittable. |
**measure_unit** | **string** | Item&#39;s unit of measurement. | [optional]
**size_prices** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureSizePrice[]**](IikoTransportPublicApiContractsNomenclatureSizePrice.md) | Prices. | [optional]
**modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureChildModifierInfo[]**](IikoTransportPublicApiContractsNomenclatureChildModifierInfo.md) | Modifiers. | [optional]
**group_modifiers** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureGroupModifierInfo[]**](IikoTransportPublicApiContractsNomenclatureGroupModifierInfo.md) | Modifier groups. | [optional]
**image_links** | **string[]** | Links to images. | [optional]
**do_not_print_in_cheque** | **bool** | Do not print on bill. | [optional]
**parent_group** | **string** | External menu group. | [optional]
**order** | **int** | Product&#39;s order (priority) in menu. | [optional]
**full_name_english** | **string** | Full name in a foreign language. | [optional]
**use_balance_for_sell** | **bool** | Weighed product. |
**can_set_open_price** | **bool** | Open price. |
**payment_subject** | **string** | Payment subject. | [optional]
**id** | **string** | ID. |
**code** | **string** | SKU. | [optional]
**name** | **string** | Name. |
**description** | **string** | Description. | [optional]
**additional_info** | **string** | Additional information. | [optional]
**tags** | **string[]** | Tags. | [optional]
**is_deleted** | **bool** | Is-Deleted attribute. | [optional]
**seo_description** | **string** | SEO description for client. | [optional]
**seo_text** | **string** | SEO text for robots. | [optional]
**seo_keywords** | **string** | SEO key words. | [optional]
**seo_title** | **string** | SEO header. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
