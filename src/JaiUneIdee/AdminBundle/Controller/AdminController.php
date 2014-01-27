<?php
namespace JaiUneIdee\AdminBundle\Controller;
use Lyra\AdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    protected function executeBatchPublish($ids)
    {
        $this->getModelManager()->setFieldValueByIds('is_published', true, $ids);
    }

    protected function executeBatchUnpublish($ids)
    {
        $this->getModelManager()->setFieldValueByIds('is_published', false, $ids);
    }
}