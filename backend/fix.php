<?php
$sourceFile = './docs/iiko/iikoapi.json';
$targetFile = './docs/iiko/iikoapi_fixed.json';

if (!file_exists($sourceFile)) {
    die("Файл $sourceFile не найден!\n");
}

$json = json_decode(file_get_contents($sourceFile), true);

// Функция для очистки имен схем
function cleanName($name) {
    if (!is_string($name)) return $name;
    // Заменяем все спецсимволы .NET на подчеркивание
    return preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
}

// 1. Рекурсивно чистим ссылки $ref
function fixRefs(&$item) {
    if (!is_array($item)) return;
    foreach ($item as $key => &$value) {
        if ($key === '$ref' && is_string($value)) {
            if (strpos($value, '#/components/schemas/') === 0) {
                $parts = explode('/', $value);
                $parts[3] = cleanName($parts[3]);
                $value = implode('/', $parts);
            }
        } elseif (is_array($value)) {
            fixRefs($value);
        }
    }
}

// 2. Исправляем пустые items в массивах (ошибка "items is missing / not of type object")
function fixEmptyItems(&$item) {
    if (!is_array($item)) return;
    if (isset($item['type']) && $item['type'] === 'array') {
        if (!isset($item['items']) || empty($item['items'])) {
            // Если items пустой или отсутствует, задаем тип object по умолчанию
            $item['items'] = ['type' => 'object'];
        }
    }
    foreach ($item as &$value) {
        if (is_array($value)) fixEmptyItems($value);
    }
}

echo "1. Обработка ссылок и пустых объектов...\n";
fixRefs($json);
fixEmptyItems($json);

// 3. Чистим ключи только в секции компонентов (схем)
if (isset($json['components']['schemas'])) {
    echo "2. Очистка имен схем...\n";
    $newSchemas = [];
    foreach ($json['components']['schemas'] as $name => $definition) {
        $newSchemas[cleanName($name)] = $definition;
    }
    $json['components']['schemas'] = $newSchemas;
}

// ВАЖНО: Мы НЕ трогаем $json['paths'], чтобы пути остались как /api/1/...

echo "3. Сохранение результата...\n";
file_put_contents($targetFile, json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Готово! Используйте $targetFile для генерации.\n";
