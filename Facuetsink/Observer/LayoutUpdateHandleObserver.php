<?php
namespace Commercepundit\Facuetsink\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

class LayoutUpdateHandleObserver implements ObserverInterface
{
    const COMMERCEPUNDIT_FACUETSINK_PRODUCT_LAYOUT_HANDLE_NAME = 'facuets_sinks_product_view';
    const COMMERCEPUNDIT_FACUETSINK_LAYOUT = 'facuets-sinks-layout';
    const CATALOG_PRODUCT_LAYOUT_HANDLE_NAME = 'catalog_product_view';

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;
    }
    /**
     * Event Observer
     *
     * @param EventObserver $observer
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(EventObserver $observer)
    {
        /** @var Event $event */
        $event = $observer->getEvent();
        $actionName = $event->getData('full_action_name');
        if ($actionName === self::CATALOG_PRODUCT_LAYOUT_HANDLE_NAME) {
            $product = $this->registry->registry('current_product');
            if (!empty($product)) {
                if ($product->getPageLayout() == self::COMMERCEPUNDIT_FACUETSINK_LAYOUT) {
                    $event->getLayout()->getUpdate()->addHandle(self::COMMERCEPUNDIT_FACUETSINK_PRODUCT_LAYOUT_HANDLE_NAME);
                }
            }
        }
    }
}
