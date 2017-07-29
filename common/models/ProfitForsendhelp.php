<?php

namespace common\models;

use Yii;

/*
staged1  0 - 30day
Staged2  31 - 60day
staged3  61 - 90day
Staged4  91 - 120day
staged5  121 - 150day
Staged6  151 - 180day
 */
class ProfitForsendhelp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profit_forsendhelp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['packet_sh', 'staged1', 'staged2', 'staged3', 'staged4', 'staged5', 'staged6', 'staged7'], 'required'],
            [['packet_sh'], 'integer'],
            [['staged1', 'staged2', 'staged3', 'staged4', 'staged5', 'staged6', 'staged7'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'packet_sh' => 'Packet Sh',
            'staged1' => 'Staged1',
            'staged2' => 'Staged2',
            'staged3' => 'Staged3',
            'staged4' => 'Staged4',
            'staged5' => 'Staged5',
            'staged6' => 'Staged6',
            'staged7' => 'Staged7',
        ];
    }
}
