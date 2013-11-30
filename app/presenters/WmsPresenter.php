<?php

/**
 * Wms presenter.
 */
class WmsPresenter extends BasePresenter
{
        /** @var Wms\wmsRepository */
        private $wmsRepository;
        
        /** @var Wms\layerRepository */
        private $layerRepository;
        
        protected function startup()
        {
            parent::startup();
            $this->wmsRepository = $this->context->wmsRepository;
            $this->layerRepository = $this->context->layerRepository;
        }
	
        public function actionDefault($id)
        {
                $this->template->id = $id;
                $this->template->layers = $this->layerRepository->findAll()->where("wms_id",$id);
                
                
                
        }
        
        
        public function renderDefault()
	{
		
                
	}

}


