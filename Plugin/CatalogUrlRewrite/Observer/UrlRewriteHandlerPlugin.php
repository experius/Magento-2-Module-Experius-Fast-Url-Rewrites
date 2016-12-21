<?php

namespace Experius\FastUrlRewrites\Plugin\CatalogUrlRewrite\Observer;

use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Observer\UrlRewriteHandler as UrlRewriteHandler;

class UrlRewriteHandlerPlugin
{
    
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Omit email sending if disabled
     *
     * @param TransportInterface $subject
     * @param \Closure $proceed
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGenerateProductUrlRewrites(
        UrlRewriteHandler $subject,
        \Closure $proceed,
        Category $category
    ) {
        $productUseCategoryUrl = $this->scopeConfig->isSetFlag(
            'catalog/seo/product_use_categories',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $category->getStoreId()
        );
        if ($productUseCategoryUrl) {
            return $proceed($category);
        }
        return [];
    }
}