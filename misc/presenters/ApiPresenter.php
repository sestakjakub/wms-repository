<?php

/**
 * Api presenter.
 */
class ApiPresenter extends BasePresenter
{
        /** @var Todo\TaskRepository */
        private $wmsRepository;
        
        /** @var Wms\layerRepository */
        private $layerRepository;
        
        protected function startup()
        {
            parent::startup();
            $this->wmsRepository = $this->context->wmsRepository;
            $this->layerRepository = $this->context->layerRepository;
            
        }
	
	public function renderDefault()
	{

	}
        
        public function renderAllWms()
        {
            $wmss = $this->wmsRepository->findAll()->select("*");
            $wmssArray = array();
            foreach ($wmss as $wms) {
                $wmsArray = array();
                $wmsArray["name"] = $wms->name;
                $wmsArray["title"] = $wms->title;
                $wmsArray["abstract"] = $wms->abstract;
                array_push($wmssArray, $wmsArray);
            }
            $this->presenter->sendResponse(new Nette\Application\Responses\JsonResponse($wmssArray));
        }
        
        public function renderLayers($id)
        {
            $layers = $this->layerRepository->findAll()->where("wms_id",$id);
            $layersArray = array();
            foreach ($layers as $layer) {
                $layerArray = array();
                $layerArray["name"] = $layer->name;
                $layerArray["title"] = $layer->title;
                $layerArray["abstract"] = $layer->abstract;
                array_push($layersArray, $layerArray);
            }
            $this->presenter->sendResponse(new Nette\Application\Responses\JsonResponse($layersArray));
        }
        

}
