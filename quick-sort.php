<?php
// test data
$unsortedArray = [
    14,
    2,
    5,
    4,
    1,
    3,
    6,
    8,
    7,
    9,
    10,
    15,
    11,
    13,
    12,
];

$sortedArray = [
    'ASC' => sortIt($unsortedArray, 'ASC'),
    'DESC' => sortIt($unsortedArray, 'DESC'),
];

echo json_encode($sortedArray);

/**
 * sort
 *
 * @param array $unsortedArray
 * @param string $orderBy
 * @return array|string
 */
function sortIt(array $unsortedArray, string $orderBy)
{
    $upperOrderBy = strtoupper($orderBy);

    switch ($upperOrderBy) {
        case 'DESC':
            return quickSortDESCAlgo($unsortedArray);
        case 'ASC':
            return quickSortASCAlgo($unsortedArray);
        default:
            return 'error!';
    }
}

/**
 * quick sort algorithm (ASC)
 *
 * @param array $unsortedArray
 * @return array
 */
function quickSortASCAlgo(array $unsortedArray) : array
{
    $length = sizeof($unsortedArray);

    if ($length <= 1) {
        return $unsortedArray;
    }

    // pivot
    $pivot = $unsortedArray[0];

    $l = 0; // 左標
    $r = $length - 1; // 右標

    while (true) {
        // 從 右標 開始找小於等於 pivot 的值，找到交換位置為止
        while ($r > $l) {
            if ($unsortedArray[$r] <= $pivot) {
                $unsortedArray[$l] = $unsortedArray[$r];
                break;
            }

            $r--;
        }

        // 從 左標 開始找大於 pivot 的值，找到交換位置為止
        while ($l <= $r) {
            if ($unsortedArray[$l] > $pivot) {
                $unsortedArray[$r] = $unsortedArray[$l];
                break;
            }

            $l++;
        }

        if ($l >= $r) {
            $unsortedArray[$r] = $pivot;
            break;
        }
    }

    // 左邊的 sort + pivot + 右邊的 sort

    $leftSort = quickSortASCAlgo(array_slice($unsortedArray, 0, $r));

    $rightSort = quickSortASCAlgo(array_slice($unsortedArray, $r + 1, $length - $l));

    return array_merge(array_merge($leftSort, [$pivot]), $rightSort);
}

function quickSortDESCAlgo(array $unsortedArray) : array
{
    $length = sizeof($unsortedArray);

    if ($length <= 1) {
        return $unsortedArray;
    }

    // pivot
    $pivot = $unsortedArray[$length - 1];

    $l = 0; // 左標
    $r = $length - 1; // 右標

    while (true) {
        // 從 左標 開始找大於 pivot 的值，找到交換位置為止
        while ($l < $r) {
            if ($unsortedArray[$l] <= $pivot) {
                $unsortedArray[$r] = $unsortedArray[$l];
                break;
            }

            $l++;
        }

        // 從 右標 開始找小於等於 pivot 的值，找到交換位置為止
        while ($r >= $l) {
            if ($unsortedArray[$r] > $pivot) {
                $unsortedArray[$l] = $unsortedArray[$r];
                break;
            }

            $r--;
        }

        if ($r <= $l) {
            $unsortedArray[$l] = $pivot;
            break;
        }
    }

    // 左邊的 sort + pivot + 右邊的 sort

    $leftSort = quickSortDESCAlgo(array_slice($unsortedArray, 0, $l));

    $rightSort = quickSortDESCAlgo(array_slice($unsortedArray, $l + 1, $length - $r));

    return array_merge(array_merge($leftSort, [$pivot]), $rightSort);
}