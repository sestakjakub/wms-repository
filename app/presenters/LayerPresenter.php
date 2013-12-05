<?php

/**
 * Layer presenter.
 */
class LayerPresenter extends BasePresenter
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
                $layer = $this->layerRepository->GetById($id);
                $this->template->layer = $layer;
                $this->template->name = $layer->name;
                $this->template->wms = $layer->wms;
                $this->template->upperLayer = $layer->layer;
                $this->template->upperUpperLayer = null;
                if ($layer->layer != null)
                {
                    $this->template->upperUpperLayer = $layer->layer->layer;
                }
        }
        
        public function actionBbox($id)
        {
                $layer = $this->layerRepository->GetById($id);
                $this->template->layer = $layer;
                $this->template->xcenter = ($layer->bBoxEast + $layer->bBoxWest)/2;
                $this->template->ycenter = ($layer->bBoxSouth + $layer->bBoxNorth)/2;
                
        }
        
        public function actionMap($id)
        {
                $layer = $this->layerRepository->GetById($id);
                $this->template->layer = $layer;
                $this->template->xcenter = ($layer->bBoxEast + $layer->bBoxWest)/2;
                $this->template->ycenter = ($layer->bBoxSouth + $layer->bBoxNorth)/2;
                
        }
        
        public function renderDefault()
	{
		$this->template->wmss = $this->wmsRepository->findAll();
                $this->template->layers = $this->layerRepository->findAll();
                
	}

}


