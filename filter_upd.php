<?php

// Предполагаемые значения переменных (для примера)
// Это значения, которые пришли из фильтра пользователя
$fbrand = ''; // Может быть 'NIKE', 'ADIDAS', или '' (пусто)
$fcolor = 'red'; // Может быть 'red', 'blue', или ''
$fsize = ''; // Может быть 'M', 'L', или ''

// Это значения текущего обрабатываемого товара (из цикла или базы данных)
$item_brand_code = 'ADIDAS';
$item_brand_id = 123;
$item_brand_name = 'Adidas Originals';
$item_color = 'red';
$item_size = 'L';

// Инициализируем массив, если он еще не инициализирован
// Важно, чтобы избежать ошибок "Undefined array key"
if (!isset($arSkuProps)) {
    $arSkuProps = [
        'size' => [],
        'color' => [],
        'brand' => []
    ];
}


/**
 * Проверяет, соответствует ли значение элемента значению фильтра.
 * Возвращает true, если значение фильтра пустое (не применяется) ИЛИ
 * если значение фильтра совпадает со значением элемента.
 *
 * @param string $filterValue Значение из пользовательского фильтра (например, $fbrand)
 * @param string $itemValue Значение соответствующего свойства текущего элемента (например, $item_brand_code)
 * @return bool
 */
function isFilterMatchOrEmpty(string $filterValue, string $itemValue): bool
{
    // Если фильтр пуст, то это всегда "совпадение" (фильтр неактивен для этого свойства)
    // ИЛИ если значение фильтра строго равно значению элемента
    return ($filterValue === '' || $filterValue === $itemValue);
}

// --- Логика добавления свойств к SKU ---

// 1. Добавляем размер, если бренд и цвет соответствуют фильтру (или фильтр пуст)
//    Т.е., если выбран бренд ИЛИ не выбран бренд, И если выбран цвет ИЛИ не выбран цвет.
if (isFilterMatchOrEmpty($fbrand, $item_brand_code) && isFilterMatchOrEmpty($fcolor, $item_color)) {
    // Добавляем размер в список доступных размеров для текущего набора фильтров
    // Используем array_unique в конце, если нужно избежать дубликатов при проходе по многим товарам
    $arSkuProps['size'][] = $item_size;
}

// 2. Добавляем цвет, если бренд и размер соответствуют фильтру (или фильтр пуст)
if (isFilterMatchOrEmpty($fbrand, $item_brand_code) && isFilterMatchOrEmpty($fsize, $item_size)) {
    // Добавляем цвет в список доступных цветов для текущего набора фильтров
    $arSkuProps['color'][] = $item_color;
}
// 3. Добавляем информацию о бренде, если цвет и размер соответствуют фильтру (или фильтр пуст)
if (isFilterMatchOrEmpty($fcolor, $item_color) && isFilterMatchOrEmpty($fsize, $item_size)) {
    // Добавляем информацию о бренде, используя код бренда как ключ,
    // чтобы избежать дублирования информации для одного и того же бренда.
    $arSkuProps['brand'][$item_brand_code] = [
        'id' => $item_brand_id,
        'code' => $item_brand_code,
        'name' => $item_brand_name,
    ];
}

// Пример вывода для проверки
echo '<pre>';
print_r($arSkuProps);
echo '</pre>';

// Если нужно получить уникальные значения в конце (например, если этот код выполняется в цикле по многим товарам)
$arSkuProps['size'] = array_values(array_unique($arSkuProps['size']));
$arSkuProps['color'] = array_values(array_unique($arSkuProps['color']));

echo '<h3>После уникализации:</h3>';
echo '<pre>';
print_r($arSkuProps);
echo '</pre>';

?>
