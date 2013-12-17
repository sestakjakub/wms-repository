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
        
        private $wmsId;
        
        protected function startup()
        {
            parent::startup();
            $this->wmsRepository = $this->context->wmsRepository;
            $this->layerRepository = $this->context->layerRepository;
        }
	
        public function actionDefault($id)
        {
                $this->wmsId = $id;
                $this->template->rootLayers = $this->layerRepository->findAll()->where("wms_id",$id)->where("layer_id", null);
        
                $wms = $this->wmsRepository->getByID($id);
                
                $keywords = array();
                foreach($wms->related("wms_has_keyword") as $key)
                {
                    $key2 = $key->keyword["keyword"];
                    array_push($keywords, $key2);
                }
                $this->template->keywords = $keywords;
        }
        
        public function getUnderlayers($id) {
            return $this->layerRepository->findAll()->where("wms_id",$this->wmsId)->where("layer_id", $id);
        }
        
        
        public function renderDefault()
	{
		
                
	}

}


