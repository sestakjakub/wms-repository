<?php

/**
 * Keywords presenter.
 */
class KeywordsPresenter extends BasePresenter
{

	/** @var Wms\KeywordRepository */
        private $keywordRepository;
        
        protected function startup()
        {
            parent::startup();
            $this->keywordRepository = $this->context->keywordRepository;
        }
	
        public function renderDefault()
	{
            $keywordsArray = array();
            $keywords2 = $this->keywordRepository->findAll();
            foreach ($keywords2 as $keyword)
            {    
                $keywordArray["keyword"]=$keyword->keyword;
                
                $wmss = $keyword->related("wms_has_keyword");
                $wmsArray = array();
                foreach ($wmss as $wms) 
                {
                    array_push($wmsArray, $wms->wms);
                }
                $keywordArray["wms"]=$wmsArray;
                
                $layerss = $keyword->related("layer_has_keyword");
                $layersArray = array();
                foreach ($layerss as $layer) 
                {
                    array_push($layersArray, $layer->layer);
                }
                $keywordArray["layer"]=$layersArray;
                
                
                array_push($keywordsArray, $keywordArray);
            }
            $this->template->keywords = $keywordsArray;
     }

}
