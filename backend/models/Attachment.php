<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\helpers\Html;
use yii\imagine\Image as Imagine;

/**
 * This is the model class for table "attachment".
 * 
 * @property integer $id
 * @property string $category
 * @property string $format
 * @property string $path
 * @property string $name
 * @property integer $visible
 *
 */
class Attachment extends \drodata\db\ActiveRecord
{
    private $_mediaRoot;
    private $_mediaWeb;

    const FORMAT_IMG = 'img';
    const FORMAT_PNG = 'png';

    const CATEGORY_SPU_IMAGE = 'spu-image';
    const CATEGORY_SKU_IMAGE = 'sku-image';

    public function init()
    {
        parent::init();
        $this->_mediaRoot = Yii::getAlias('@static');
        $this->_mediaWeb = Yii::getAlias('@staticweb');

        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteJunctionRecords']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteFile']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachment';
    }


    /**
     * key means scenario names
     */
    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'format', 'path'], 'required'],
            [['visible'], 'integer'],
            [['format'], 'string', 'max' => 10],
            [['category', 'path'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => '分类',
            'format' => '文件格式',
            'path' => 'hashed 相对路径',
            'name' => '原始文件名',
            'visible' => 'Visible',
        ];
    }

    /**
     * 反回操作链接
     *
     * @param string $action action name
     * @param array $configs 参考 Html::actionLink()
     * @return mixed the link html content
     */
    public function actionLink($action, $configs = [])
    {
        list($route, $options) = $this->getActionOptions($action);

        return Html::actionLink($route, ArrayHelper::merge($options, $configs));
    }

    /**
     * 返回 actionLink() 核心属性
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 两个个元素依次表示：action route, action link options
     *
     */
    protected function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/attachment/$action", 'id' => $this->id];

        switch ($action) {
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                break;

            case 'delete':
                $options = [
                    'title' => '删除',
                    'icon' => 'trash',
                    'color' => 'danger',
                    'data' => [
                        'method' => 'post',
                        'confirm' => '确定要执行删除操作吗？',
                    ],
                ];
                break;

            default:
                break;
        }

        // combine control options with common options
        return [$route, ArrayHelper::merge($options, [
            'type' => 'icon',
            'visible' => $visible,
            'disabled' => $hint,
            'disabledHint' => $hint,
        ])];
    }

    // ==== getters start ====

    /**
     * 获取关联表记录
     */
    public function getJunctionRecords()
    {
        switch ($this->category) {
            case self::CATEGORY_SPU_IMAGE:
                return $this->hasMany(SpuImage::className(), ['attachment_id' => 'id']);
                break;
            case self::CATEGORY_SKU_IMAGE:
                return $this->hasMany(SkuImage::className(), ['attachment_id' => 'id']);
                break;
        }
    }

    public function setMediaRoot($name)
    {
        $this->_mediaRoot = $name;
    }
    public function getMediaRoot()
    {
        return $this->_mediaRoot;
    }
    public function setMediaWeb($name)
    {
        $this->_mediaWeb = $name;
    }
    public function getMediaWeb()
    {
        return $this->_mediaWeb;
    }

    public static function defaultUrl($size= 'original')
    {
        return $this->mediaWeb . "/default-$size.png";
    }
    /**
     * - 'o': origin 
     * - 'l': large 480x480
     * - 's': small 240x240
     * - 't': thumbnail 120x120
     */
    public function getRelativePath($size= 'o')
    {
        $slices = explode('.', $this->path);
        $head = $slices[0];
        $suffix = $size == 'o' ? '' : '_' . $size;
        $tail = '.' . $slices[1];
        return $head . $suffix . $tail;
    }
    public function getPath($size= 'o')
    {
        return $this->mediaRoot . '/' . $this->getRelativePath($size);
    }
    public function getUrl($size= 'o')
    {
		if (!file_exists($this->getPath($size))) {
            return $this->mediaWeb . "/default-$size.png";
        }
        return $this->mediaWeb . '/' . $this->getRelativePath($size);
    }
    public function getThumbnail($width = 60)
    {
        $imgOptions = [
            'title' => $this->name,
            'style' => "max-width:{$width}px",
        ];
        
        return Html::a(
            Html::img($this->getUrl('t'), $imgOptions),
            $this->url,
            [
                'target' => '_blank',
            ]
        );
    }

    /**
     * 判断媒体类型是否是图片
     */
    public function getIsImage()
    {
        return $this->format == self::FORMAT_IMG;
    }

    // ==== getters end ====

    /**
     * 根据文件在服务器上的临时名词转换成 hash 名字，设置 path 列值
     *
     * @param yii\web\UploadedFile $file
     */
    public function storeFile($file)
    {
        $slices = [
            md5_file($file->tempName),
            $this->format,
            time(),
        ];
        $hash = md5(implode('-', $slices));
        $dirA = substr($hash, 0, 2);
        $dirB = substr($hash, 2, 4);
        $fileName = substr($hash, 6);
        $extension = $file->extension;

        $root = $this->getMediaRoot();

        $this->path = $dirA . '/' . $dirB . '/' . $fileName . '.' . $extension;

        $absolutePath = $root . '/' . $this->path;

        // save original image, create sub directory if need
		if (!file_exists($root . '/' . $dirA)) {
            mkdir($root .'/' . $dirA, 0755, true);
        }
		if (!file_exists($root . '/' . $dirA . '/' . $dirB)) {
            mkdir($root .'/' . $dirA . '/' . $dirB, 0755, true);
        }
        $file->saveAs($absolutePath);

        if ($this->getIsImage()) {
            static::generateThumbnails($absolutePath);
        }
    }

    public static function generateThumbnails($imagePath)
    {
        $types = [
            [
                'suffix' => 'l',
                'width' => 960,
                'height' => 960,
            ],
            [
                'suffix' => 's',
                'width' => 480,
                'height' => 480,
            ],
            [
                'suffix' => 't',
                'width' => 120,
                'height' => 120,
            ],
        ];
        $pathParts = pathinfo($imagePath);
        foreach ($types as $type) {
            $cropPath = $pathParts['dirname'] . '/' . $pathParts['filename'] . "_{$type['suffix']}." . $pathParts['extension'];
            Imagine::thumbnail($imagePath, $type['width'], $type['height'],\Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)
            ->save($cropPath, ['quality' => 90]);
        }
    }

    /**
     * 删除关联表中的记录
     *
     * 由 self::EVENT_BEFORE_DELETE 触发
     */
    public function deleteJunctionRecords($event)
    {
        $records = $this->junctionRecords;

        if ($records) {
            foreach ($records as $record) {
                if (!$record->delete()) {
                    throw new \yii\db\Exception('Failed to flush.');
                }
            }
        }
    }

    /**
     * 删除实际的文件
     *
     * Trigger by Image::EVENT_AFTER_DELETE
     */
    public function deleteFile($event)
    {
        $sizes = ['o', 'l', 's', 't'];
        foreach ($sizes as $size) {
            $path = $this->getPath($size);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
