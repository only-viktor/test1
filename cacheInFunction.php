<?php

use Yii;

function ($date, $type)
{
    $userId = Yii::$app->user->id;

    $cacheKey = md5(implode(':', [ $userId, $date, $type ]));
    $cacheDuration = 3600;

    $result = Yii::$app->cache->getOrSet($cacheKey, function () use ($date, $type, $userId) {

        $dataList = SomeDataModel::find()->where([
            'date'    => $date,
            'type'    => $type,
            'user_id' => $userId,
        ])->all();

        $result = [];

        if (!empty($dataList)) {
            foreach ($dataList as $dataItem) {
                $result[ $dataItem->id ] = [ 'a' => $dataItem->a, 'b' => $dataItem->b ];
            }
        }

        return $result;

    }, $cacheDuration);

    return $result;
}
