<?php

namespace TrainingMonish\DailyDeal\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class HotCategory extends \Magento\CatalogWidget\Block\Product\ProductsList
{

    protected $_productsCollection;
    protected $_productCollectionFactory;
    protected $_categoryFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder,
        \Magento\CatalogWidget\Model\Rule $rule,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $collection,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_products = $collection;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $data
        );
    }

    public function getProductsAllCollection()
    {
        $todayDate = date('m/d/y');
        $tomorrow = mktime(0, 0, 0, date('m'), date('d'), date('y'));
        $tomorrowDate = date('m/d/y', $tomorrow);

        $categoryId = trim($this->getCategories(), 'category/');
        if ($categoryId != "") {
            $categoryObj = $this->_categoryFactory->create()->load($categoryId);
        }
        $productsCount = $this->getProductsCount();

        $this->_productsCollection = $this->_productCollectionFactory->create();
        $this->_productsCollection
        ->addAttributeToSelect('*')
        ->addAttributeToSort('name')
        ->setPageSize(0)
        ->addAttributeToFilter(
            [
                ['attribute'=> 'status','eq' => 1]
            ]
        )
        ->addAttributeToFilter(
            [
                [
                    'attribute'=> 'visibility',
                    'in' => [
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH,
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                    ]
                ]
            ]
        )
        ->addAttributeToFilter(
            [
                [
                    'attribute'=> 'special_from_date',
                    ['date' => true, 'to' => $todayDate]
                ]
            ]
        )
        ->addAttributeToFilter(
            [
                [
                    'attribute'=> 'special_to_date',
                    [
                        'or'=> [0 => ['date' => true, 'from' => $tomorrowDate]]
                    ],
                ]
            ]
        )
        ->addAttributeToFilter(
            [
                ['attribute'=> 'vsourz_include_hotdeals','eq' => true]
            ]
        );
        if ($categoryId != "") {
            $this->_productsCollection->addCategoryFilter($categoryObj);
        }

        $this->_productsCollection->getSelect()->limit($productsCount);

        return $this->_productsCollection;
    }

    public function getCategoryFactory()
    {
        return $this->_categoryFactory;
    }

    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    public function getCategoryCollections()
    {
        return $this->_categoryCollection;
    }

    public function getSpecialPrice($_product)
    {
        return $_product->getSpecialPrice();
    }

    public function getNormalPrice($_product)
    {
        return $_product->getPrice();
    }

    public function getSavedAmount($_product)
    {
        $specialPrice = $this->getSpecialPrice($_product);
        $normalPrice = $this->getNormalPrice($_product);

        if ($specialPrice == "" || $specialPrice == null) {
            $yousave = 0;
        } else {
            $yousave = $normalPrice - $specialPrice;
        }
        $yousave = number_format($yousave, 2, '.', '');

        return $yousave;
    }

    public function getDiscountPercent($_product)
    {
        $specialPrice = $this->getSpecialPrice($_product);
        $normalPrice = $this->getNormalPrice($_product);
        if ($specialPrice == "" || $specialPrice == null) {
            $discountpercent = 0;
        } else {
            $discountpercent = 100 - ($specialPrice*100)/$normalPrice;
        }

        $discountpercent = number_format($discountpercent, 2, '.', '');
        return $discountpercent;
    }

    public function getCategoryCollectionFactory()
    {
        return $this->_categoryCollectionFactory;
    }

    public function getCategoryCollectionByIds()
    {
        $categories = explode(',', trim($this->getCategories(), 'category/'));
        $collection = $this->_categoryCollectionFactory->create()
                ->addAttributeToSelect('*')
                ->addFieldToFilter('entity_id', ['in' => $categories])
                ->addFieldToFilter('is_active', 1)
                ->setOrder('position', 'ASC');
        return $collection;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getProductPriceHtml(
        \Magento\Catalog\Model\Product $product,
        $priceType = null,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }
        $arguments['price_id'] = isset($arguments['price_id'])
            ? $arguments['price_id']
            : 'old-price-' . $product->getId() . '-' . $priceType;
        $arguments['include_container'] = isset($arguments['include_container'])
            ? $arguments['include_container']
            : true;
        $arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
            ? $arguments['display_minimal_price']
            : true;

            /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                $arguments
            );
        }
        return $price;
    }
}
