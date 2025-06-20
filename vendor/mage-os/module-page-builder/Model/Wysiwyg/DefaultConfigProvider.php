<?php
/**
 * Copyright 2018 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento\PageBuilder\Model\Wysiwyg;

use Magento\Framework\DataObject;
use Magento\Framework\View\Asset\Repository;

/**
 * This DefaultConfigProvider overrides existing configuration provided from the cms module
 */
class DefaultConfigProvider implements \Magento\Framework\Data\Wysiwyg\ConfigProviderInterface
{
    /**
     * @var Repository
     */
    private Repository $assetRepo;
    /**
     * @var array
     */
    private $additionalSettings;
    /**
     * @param Repository $assetRepo
     * @param array $additionalSettings
     */
    public function __construct(
        Repository $assetRepo,
        array $additionalSettings
    ) {
        $this->assetRepo = $assetRepo;
        $this->additionalSettings = $additionalSettings;
    }
    /**
     * Returns configuration data
     *
     * @param DataObject $config
     * @return DataObject
     */
    public function getConfig(DataObject $config): DataObject
    {
        $defaultSettings = [
            'menubar' => 'edit insert view format table help',
            'statusbar' => false,
            'image_advtab' => true,
            'promotion' => false,
        ];

        $config->addData(
            [
                'tinymce' => [
                    'toolbar' => 'blocks | fontfamily fontsizeinput lineheight | forecolor backcolor | '
                        . 'bold italic underline | alignleft aligncenter alignright alignjustify | '
                        . 'bullist numlist | link image',

                    'plugins' => implode(
                        ' ',
                        [
                            'advlist',
                            'anchor',
                            'autolink',
                            'charmap',
                            'code',
                            'codesample',
                            'directionality',
                            'emoticons',
                            'help',
                            'image',
                            'link',
                            'lists',
                            'media',
                            'nonbreaking',
                            'preview',
                            'table',
                            'visualblocks',
                            'visualchars',
                        ]
                    ),
                    'content_css' => [
                        $this->assetRepo->getUrl('mage/adminhtml/wysiwyg/tiny_mce/themes/ui.css'),
                        $this->assetRepo->getUrl('Magento_PageBuilder::css/source/form/element/tinymce.css')
                    ]
                ],
                'settings' => array_replace_recursive($defaultSettings, $this->additionalSettings),
            ]
        );
        return $config;
    }
}
